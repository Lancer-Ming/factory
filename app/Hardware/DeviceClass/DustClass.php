<?php

namespace App\Hardware\DeviceClass;

use App\Models\Code;
use GatewayWorker\Lib\Gateway;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DustClass
{
    /** 消息
     * @var string
     */
    protected $message = "";

    /**格式化的数据
     * @var
     */
    protected $processMessage;

    /** 生成唯一的设备标识
     * @var
     */
    protected $sn;

    /** 是否是刚上线
     * @var bool
     */
    protected $isInit = false;

    /** 判断sn是否已经生成过了
     * @var
     */
    protected $snIsHaved = false;

    /** 客户端唯一标识
     * @var
     */
    protected $client_id;


    protected $isTest;
    /** 构造接收消息
     * Entrance constructor.
     * @param $message\
     */
    public function __construct($message='')
    {
        $this->message = str_replace(array("\r\n", "\r", "\n"),"", $message);
//        $this->isTest = true;
    }

    /** 将后台的数据存入到数据库里
     * @return string|void
     * @throws \Exception
     */
    public function store($client_id)
    {
        $this->client_id = $client_id;
        Log::info('1'.$this->message);
        // 检验
        if (!$this->CRC_16_Check()) {
            Log::info('2'.$this->message);
            return;
        }

        // 将数据进行格式化
        $this->formatData();

        $processMessage = $this->processMessage;

        // 如果 processMessage 是包含IMEI号  就是首次访问。
        if (array_key_exists('IMEI', $processMessage)) {
            Log::info('4'.json_encode($processMessage));
            // 确认是刚上线
            $this->isInit = true;
            // 查询 IMEI 号
            $sn = DB::select('select sn from ams_dust_codes WHERE IMEI = ?', [$processMessage['IMEI']]);
            if ($sn) {
                // 如果查询到了 说明已经储存过了
                $this->snIsHaved = true;
                $this->sn = $sn[0]->sn;
                // 将sn 作为Uid 与 client_id 进行绑定
                Gateway::bindUid($this->client_id, $this->sn);
                // 每次都需要插入一条新的client_id 记录
                $time = date('Y-m-d H:i:s', time());
                DB::insert('insert into ams_dust_codes (sn, IMEI, client_id, created_at) values (?, ?, ?, ?)', [$this->sn,$processMessage['IMEI'], $this->client_id,  $time]);

                // 改变 dust 状态
                $this->changeStatus($client_id);
                return;
            } else {
                $this->sn = $this->createRandomUniqueCode();

                // 将sn 作为Uid 与 client_id 进行绑定
                Gateway::bindUid($client_id, $this->sn);

                // 改变 dust 状态
                $this->changeStatus($client_id);

                // 每次都需要插入一条新的client_id 记录
                $time = date('Y-m-d H:i:s', time());
                DB::insert('insert into ams_dust_codes (sn, IMEI, client_id, created_at) values (?, ?, ?, ?)', [$this->sn,$processMessage['IMEI'], $this->client_id,  $time]);
                return;
            }

        } else {        // 不是首次访问，发数据包了
            $this->isInit = false;
            // 如果是测试环境
            if ($this->isTest) {
                Log::info('测试：'.$this->message);
                $this->storeTestData($processMessage);
            } else {
                $this->sn =  substr($processMessage['MN'], -6);      // 生成sn
                Log::info('sn::::'.json_encode($this->sn));
                // 将sn 作为Uid 与 client_id 进行绑定
                Gateway::bindUid($this->client_id, $this->sn);
                $this->storeProductionData($processMessage);
            }
        }

    }

    /**
     * 改变 dust 在线状态
     */
    public function changeStatus($client_id)
    {
        // 新增带有 sn 的扬尘设备
        if (!DB::select('select id from ams_dusts where sn = ?', [$this->sn])) {
            DB::insert('insert into ams_dusts (sn) values (?)', [$this->sn]);
        }

        // 根据client_id获取sn
        $sn = Gateway::getUidByClientId($client_id);
        Log::info(json_encode('sn........'.json_encode($sn)));
        $is_online = Gateway::isUidOnline($sn);
        if ($is_online) {
            DB::update('update ams_dusts set is_online=1 WHERE sn = ?', [$sn]);
        }
    }

    /** 发送数据给硬件
     * @return string
     */
    public function sendConnectData()
    {
        if (!$this->isInit) {
           return 'ok';
        }
        // 主体数据内容
        $result_content = 'SN=' . $this->sn . ';DATETIME=' . date('YmdHis', time()) . '&&';

        // CRC16加密
        $crc = $this->CRC_16($result_content, strlen($result_content));
        $validate_code = strtoupper(str_pad(base_convert($crc, 10, 16), 4, STR_PAD_LEFT));
        // 最终数据，含包头包尾
        $result_all = '##' . str_pad(strlen($result_content), 4, 0, 0) . $result_content . $validate_code;
        return $result_all;
    }

    public function insertCloseTime($client_id)
    {
        $data = DB::select('select sn, id from ams_dust_codes WHERE client_id = ?', [$client_id]);
        if ($data) {
            $sn = $data[0]->sn;
        }
        Log::info('inserCloseTime-----------'.json_encode($sn));
        // 如果 $sn 是空数组 直接return
        if (empty($sn)) {
            return;
        }
        // 查询要退出的那个id
        $id = DB::select("select id from ams_dust_codes where sn = ? ORDER BY id desc LIMIT 1", [$sn])[0]->id;
        Log::info('id------------------------'.$id);
        $time = date('Y-m-d H:i:s', time());
        DB::update('update ams_dust_codes set updated_at = ? WHERE id = ?', [$time, $id]);
        DB::update('update ams_dusts set is_online=0, pre_warn_count=0, cur_warn_count=0 WHERE sn = ?', [$sn]);
    }


    /**
     *  储存测试环境数据
     */
    protected function storeTestData($processMessage)
    {
        $time = date('Y-m-d H:i:s', time());
        // 新增扬尘数据信息
        DB::insert('insert into ams_dust_infos
        (sn, received_at, flag, QN, CN, a34001_Rtd, a34002_Rtd, a34004_Rtd, LA_Rtd, a01001_Rtd, a01002_Rtd, a01006_Rtd, a01007_Rtd, a01008_Rtd) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', ['971228', $time, $processMessage['Flag'], $processMessage['QN'], $processMessage['CN'], $processMessage['a34001-Rtd'], $processMessage['a34002-Rtd'], $processMessage['a34004-Rtd'], $processMessage['LA-Rtd'], $processMessage['a01001-Rtd'], $processMessage['a01002-Rtd'], $processMessage['a01006-Rtd'], $processMessage['a01007-Rtd'], $processMessage['a01008-Rtd']]);
    }

    /**
     *  储存生产环境数据
     */
    protected function storeProductionData($processMessage)
    {
        $time = date('Y-m-d H:i:s', time());
        // 获取标准值
        $standard = DB::select('select * from ams_dust_standards where sn = ?', [$this->sn]);
        $standard = $standard ? $standard[0] : DB::select('select * from ams_dust_standards where sn = ?', ['0'])[0];

        $warningMessage = [];
        // 扬尘预警
        $warningMessage['a34001_Rtd_pre_warning'] = ((float) $processMessage['a34001-Rtd'] >= $standard->a34001_Rtd_pre_warning && (float) $processMessage['a34001-Rtd'] < $standard->a34001_Rtd_is_warning) ? 1 : 0;
        // 扬尘报警
        $warningMessage['a34001_Rtd_is_warning'] = (float) $processMessage['a34001-Rtd'] >= $standard->a34001_Rtd_is_warning ? 1 : 0;
        // PM10 预警
        $warningMessage['a34002_Rtd_pre_warning'] = ((float) $processMessage['a34002-Rtd'] >= $standard->a34001_Rtd_pre_warning && (float) $processMessage['a34002-Rtd'] < $standard->a34001_Rtd_is_warning) ? 1 : 0;
        // PM10 报警
        $warningMessage['a34002_Rtd_is_warning'] = (float) $processMessage['a34002-Rtd'] >= $standard->a34001_Rtd_is_warning ? 1 : 0;
        // PM2.5 预警
        $warningMessage['a34004_Rtd_pre_warning'] = ((float) $processMessage['a34004-Rtd'] >= $standard->a34004_Rtd_pre_warning && (float) $processMessage['a34004-Rtd'] < $standard->a34004_Rtd_is_warning) ? 1 : 0;
        // PM2.5 报警
        $warningMessage['a34004_Rtd_is_warning'] = (float) $processMessage['a34004-Rtd'] >= $standard->a34004_Rtd_is_warning ? 1 : 0;
        // 噪音上限预警
        $warningMessage['LA_Rtd_pre_warning'] = ((float) $processMessage['LA-Rtd'] >= $standard->LA_Rtd_pre_warning && (float) $processMessage['LA-Rtd'] < $standard->LA_Rtd_is_warning) ? 1 : 0;
        // 噪音上限报警
        $warningMessage['LA_Rtd_is_warning'] = (float) $processMessage['LA-Rtd'] >= $standard->LA_Rtd_is_warning ? 1 : 0;
        // 温度上限预警
        $warningMessage['a01001_Rtd_high_pre_warning'] = ((float) $processMessage['a01001-Rtd'] >= $standard->a01001_Rtd_high_pre_warning && (float) $processMessage['a01001-Rtd'] < $standard->a01001_Rtd_high_is_warning) ? 1 : 0;
        // 温度上限报警
        $warningMessage['a01001_Rtd_high_is_warning'] = (float) $processMessage['a01001-Rtd'] >= $standard->a01001_Rtd_high_is_warning ? 1 : 0;
        // 温度下限预警
        $warningMessage['a01001_Rtd_low_pre_warning'] = ((float) $processMessage['a01001-Rtd'] <= $standard->a01001_Rtd_low_pre_warning && (float) $processMessage['a01001-Rtd'] > $standard->a01001_Rtd_low_is_warning) ? 1 : 0;
        // 温度下限报警
        $warningMessage['a01001_Rtd_low_is_warning'] = (float) $processMessage['a01001-Rtd'] <= $standard->a01001_Rtd_low_is_warning ? 1 : 0;
        // 湿度上限预警
        $warningMessage['a01002_Rtd_pre_warning'] = ((float) $processMessage['a01002-Rtd'] >= $standard->a01002_Rtd_pre_warning && (float) $processMessage['a01002-Rtd'] < $standard->a01002_Rtd_is_warning) ? 1 : 0;
        // 湿度上限报警
        $warningMessage['a01002_Rtd_is_warning'] = (float) $processMessage['a01002-Rtd'] >= $standard->a01002_Rtd_is_warning ? 1 : 0;
        // 气压上限预警
        $warningMessage['a01006_Rtd_high_pre_warning'] = ((float) $processMessage['a01006-Rtd'] >= $standard->a01006_Rtd_high_pre_warning && (float) $processMessage['a01006-Rtd'] < $standard->a01006_Rtd_high_is_warning) ? 1 : 0;
        // 气压上限报警
        $warningMessage['a01006_Rtd_high_is_warning'] = (float) $processMessage['a01006-Rtd'] >= $standard->a01006_Rtd_high_is_warning ? 1 : 0;
        // 气压下限预警
        $warningMessage['a01006_Rtd_low_pre_warning'] = ((float) $processMessage['a01006-Rtd'] <= $standard->a01006_Rtd_low_pre_warning && (float) $processMessage['a01006-Rtd'] > $standard->a01006_Rtd_low_is_warning) ? 1 : 0;
        // 气压下限报警
        $warningMessage['a01006_Rtd_low_is_warning'] = (float) $processMessage['a01006-Rtd'] <= $standard->a01006_Rtd_low_is_warning ? 1 : 0;
        // 风速上限预警
        $warningMessage['a01007_Rtd_pre_warning'] = ((float) $processMessage['a01007-Rtd'] >= $standard->a01007_Rtd_pre_warning && (float) $processMessage['a01007-Rtd'] < $standard->a01007_Rtd_is_warning) ? 1 : 0;
        // 风速上限报警
        $warningMessage['a01007_Rtd_is_warning'] = (float) $processMessage['a01007-Rtd'] >= $standard->a01007_Rtd_is_warning ? 1 : 0;

        Log::info('warningMessage--------'.json_encode($warningMessage));
        // 判断是否有报警
        if ($warningMessage['a01007_Rtd_is_warning'] || $warningMessage['a01006_Rtd_low_is_warning'] || $warningMessage['a01006_Rtd_high_is_warning'] ||
            $warningMessage['a01002_Rtd_is_warning'] || $warningMessage['a01001_Rtd_low_is_warning'] || $warningMessage['a01001_Rtd_high_is_warning'] ||
            $warningMessage['LA_Rtd_is_warning'] || $warningMessage['a34004_Rtd_is_warning'] || $warningMessage['a34002_Rtd_is_warning'] || $warningMessage['a34001_Rtd_is_warning']) {
            $warningMessage['is_warning_status'] = 1;
            $warningMessage['pre_warning_status'] = 0;
        } elseif ($warningMessage['a01007_Rtd_pre_warning'] || $warningMessage['a01006_Rtd_low_pre_warning'] || $warningMessage['a01006_Rtd_high_pre_warning'] ||
            $warningMessage['a01002_Rtd_pre_warning'] || $warningMessage['a01001_Rtd_low_pre_warning'] || $warningMessage['a01001_Rtd_high_pre_warning'] ||
            $warningMessage['LA_Rtd_pre_warning'] || $warningMessage['a34004_Rtd_pre_warning'] || $warningMessage['a34002_Rtd_pre_warning'] || $warningMessage['a34001_Rtd_pre_warning']) {
            // 判断是否有预警
            $warningMessage['pre_warning_status'] = 1;
            $warningMessage['is_warning_status'] = 0;
        } else {
            $warningMessage['is_warning_status'] = 0;
            $warningMessage['pre_warning_status'] = 0;
        }

        Log::info("warning-----------".json_encode($warningMessage['pre_warning_status']).json_encode($warningMessage['is_warning_status']));
        // 新增扬尘数据信息
        $id = DB::table('dust_infos')->insertGetId(['sn'=>$this->sn, 'received_at'=>$time, 'flag'=>$processMessage['Flag'], 'QN'=>$processMessage['QN'], 'CN'=>$processMessage['CN'], 'a34001_Rtd'=>$processMessage['a34001-Rtd'], 'a34002_Rtd'=>$processMessage['a34002-Rtd'],
            'a34004_Rtd'=>$processMessage['a34004-Rtd'], 'LA_Rtd'=>$processMessage['LA-Rtd'], 'a01001_Rtd'=>$processMessage['a01001-Rtd'], 'a01002_Rtd'=>$processMessage['a01002-Rtd'], 'a01006_Rtd'=>$processMessage['a01006-Rtd'], 'a01007_Rtd'=>$processMessage['a01007-Rtd'], 'a01008_Rtd'=>$processMessage['a01008-Rtd']]);
        Log::info("insert dust\n");
        DB::update('update ams_dust_infos set a34001_Rtd_pre_warning = ?, a34001_Rtd_is_warning = ?, a34002_Rtd_pre_warning = ?, a34002_Rtd_is_warning = ?, a34004_Rtd_pre_warning = ?, a34004_Rtd_is_warning = ?,
        LA_Rtd_pre_warning = ?, LA_Rtd_is_warning = ?, a01001_Rtd_high_pre_warning = ?, a01001_Rtd_high_is_warning = ?, a01001_Rtd_low_pre_warning = ?, a01001_Rtd_low_is_warning = ?,
        a01002_Rtd_pre_warning = ?, a01002_Rtd_is_warning = ?, a01006_Rtd_high_pre_warning = ?, a01006_Rtd_low_pre_warning = ?, a01006_Rtd_high_is_warning = ?, a01006_Rtd_low_is_warning = ?,
        a01007_Rtd_pre_warning = ?, a01007_Rtd_is_warning = ?, pre_warning_status = ?, is_warning_status = ? WHERE id = ?', [$warningMessage['a34001_Rtd_pre_warning'],
            $warningMessage['a34001_Rtd_is_warning'], $warningMessage['a34002_Rtd_pre_warning'], $warningMessage['a34002_Rtd_is_warning'], $warningMessage['a34004_Rtd_pre_warning'], $warningMessage['a34004_Rtd_is_warning'],
            $warningMessage['LA_Rtd_pre_warning'], $warningMessage['LA_Rtd_is_warning'], $warningMessage['a01001_Rtd_high_pre_warning'], $warningMessage['a01001_Rtd_high_is_warning'], $warningMessage['a01001_Rtd_low_pre_warning'], $warningMessage['a01001_Rtd_low_is_warning'],
            $warningMessage['a01002_Rtd_pre_warning'], $warningMessage['a01002_Rtd_is_warning'], $warningMessage['a01006_Rtd_high_pre_warning'], $warningMessage['a01006_Rtd_low_pre_warning'], $warningMessage['a01006_Rtd_high_is_warning'], $warningMessage['a01006_Rtd_low_is_warning'],
            $warningMessage['a01007_Rtd_pre_warning'], $warningMessage['a01007_Rtd_is_warning'], $warningMessage['pre_warning_status'], $warningMessage['is_warning_status'], $id]);
        // 更新扬尘是否预警报警
        DB::update("update ams_dusts set pre_warn_count = ?,cur_warn_count = ? where sn = ?", [$warningMessage['pre_warning_status'], $warningMessage['is_warning_status'], $this->sn]);
    }


    /** 将后台数据按要求进行格式化
     * @return $this|array
     */
    protected function formatData()
    {
        Log::info('formatData....');
        // a34004-Rtd：PM2.5    a34002-Rtd：PM10    a34001-Rtd：总悬浮颗粒物 TSP    LA-Rtd：噪音
        // a01001-Rtd：温度    a01002-Rtd：湿度   a01006-Rtd：气压   a01007-Rtd：风速   a01008-Rtd：风向
        $this->message = substr($this->message, 6, -6);
        $arrayData = explode(";", $this->message);

        $formatData = [];
        forEach ($arrayData as $data) {
            $split = explode("=", $data);
            // 如果分隔出来的数组元素长度大于2 也就是有多个键值对
            if (count($split) > 2) {
                forEach ($split as $key => $value) {
                    $value = str_replace('&&', '', $value);
                    // 第一个要取消掉
                    if ($key % 2 != 0 && $key > 0) {
                        $formatData[$value] = $split[$key + 1];
                    }
                }
            } else {
                $formatData[$split[0]] = $split[1];
            }
        }
        // 将格式化好的数据赋值给$processMessage
        $this->processMessage = $formatData;

        Log::info('3');

        return $this;
    }

    /**CRC16 循环冗余校验算法
     * @param $puchMsg 需要校验的字符串
     * @param $usDataLen 需要校验的字符串长度
     * @return int 返回 CRC16 校验码
     */
    protected function CRC_16($puchMsg, $usDataLen)
    {
        $crc_reg = 0xFFFF;
        for ($i = 0; $i < $usDataLen; $i++) {
            $crc_reg = ($crc_reg >> 8) ^ ord($puchMsg[$i]);
            for ($j = 0; $j < 8; $j++) {
                $check = $crc_reg & 0x0001;
                $crc_reg >>= 1;
                if ($check == 0x0001) {
                    $crc_reg ^= 0xA001;
                }
            }
        }
        return $crc_reg;
    }

    /** CRC_16 检验逻辑
     * @return bool 如果检验通过 返回 true 反之返回 false
     */
    protected function CRC_16_Check()
    {
        $validateCode = substr($this->message, -4);
        $puchMsg = substr($this->message, 6, -4);
        $usDataLen = strlen($puchMsg);
        $crc = $this->CRC_16($puchMsg, $usDataLen);
        Log::info('validate:'.$validateCode.'--------'.strtoupper(base_convert($crc, 10, 16)));
        return (strtoupper(base_convert($crc, 10, 16))) == $validateCode;
    }

    /** 随机独立的6位码
     * @return int
     */
    protected function createRandomUniqueCode()
    {
        $flag = Code::where('type', 1)->first();


        if ($flag) {
            // 如果数据库有类型
            $code = (int)($flag->code) + 1;
            $hostCode = str_pad($code, 6, 0, STR_PAD_LEFT);

            // 添加到数据库
            $flag->code = $code;
            $flag->save();

        } else {
            // 添加一个到数据库
            Code::insert(['code' => 1, 'type' => 1]);
            return str_pad(1, 6, 0, STR_PAD_LEFT);
        }

        return $hostCode;
    }


}