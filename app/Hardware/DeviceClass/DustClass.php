<?php

namespace App\Hardware\DeviceClass;

use App\Models\Code;
use Illuminate\Support\Facades\DB;

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

    /** 与硬件交互的client_id
     * @var
     */
    protected $client_id;

    /** 生成唯一的设备标识
     * @var
     */
    protected $sn;

    /** 构造接收消息
     * Entrance constructor.
     * @param $message\
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /** 将后台数据按要求进行格式化
     * @return $this|array
     */
    public function formatData()
    {

        // a34004-Rtd：PM2.5    a34002-Rtd：PM10    a34001-Rtd：总悬浮颗粒物 TSP    LA-Rtd：噪音
        // a01001-Rtd：温度    a01002-Rtd：湿度   a01006-Rtd：气压   a01007-Rtd：风速   a01008-Rtd：风向
        $this->message = substr($this->message, 6, -6);
        $arrayData = explode(";", $this->message);
        //
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

        return $this;
    }

    /** 将后台的数据存入到数据库里
     * @param $client_id
     * @return string|void
     * @throws \Exception
     */
    public function store($client_id)
    {
        // 检验
        if (!$this->CRC_16_Check()) {
            return;
        }

        // 将数据进行格式化
        $this->formatData();
        $processMessage = $this->processMessage;
//        return $processMessage;
        // 将数据储存到dust_code表
        $time = date('Y-m-d H:i:s', time());
        try {
            DB::insert('insert into ams_dust_codes (client_id, sn, created_at, updated_at) values (?, ?, ?, ?)'
                , [$client_id, $processMessage['MN'], $time, $time]);

            DB::insert('insert into ams_dust_infos
        (sn, received_at, flag, QN, CN, a34001_Rtd, a34002_Rtd, a34004_Rtd, LA_Rtd, a01001_Rtd, a01002_Rtd, a01006_Rtd, a01007_Rtd, a01008_Rtd) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$processMessage['MN'], $time, $processMessage['Flag'], $processMessage['QN'], $processMessage['CN'], $processMessage['a34001-Rtd'], $processMessage['a34002-Rtd'],
                $processMessage['a34004-Rtd'], $processMessage['LA-Rtd'], $processMessage['a01001-Rtd'], $processMessage['a01002-Rtd'],
                $processMessage['a01006-Rtd'], $processMessage['a01007-Rtd'], $processMessage['a01008-Rtd']]);

        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**CRC16 循环冗余校验算法
     * @param $puchMsg 需要校验的字符串
     * @param $usDataLen 需要校验的字符串长度
     * @return int 返回 CRC16 校验码
     */
    public function CRC_16($puchMsg, $usDataLen)
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
    public function CRC_16_Check()
    {
        $validateCode = substr($this->message, -4);
        $puchMsg = substr($this->message, 6, -4);
        $usDataLen = strlen($puchMsg);
        $crc = $this->CRC_16($puchMsg, $usDataLen);
        return strtoupper(base_convert($crc, 10, 16)) === $validateCode;
    }

    /** 随机独立的6位码
     * @return int
     */
    public function createRandomUniqueCode()
    {
        $flag = Code::where('type', 1)->first();


        if ($flag) {
            // 如果数据库有类型
            $code = (int) ($flag->code) + 1;
            $mm = date('m', time());
            $hostCode = str_pad(base_convert($code, 10, 16), 4, 0, STR_PAD_LEFT).$mm;

            // 添加到数据库
            $flag->code = $code;
            $flag->save();

            return $hostCode;
        }
        else {
            // 添加一个到数据库
            Code::insert(['code'=> 10000, 'type'=> 1]);
        }
    }

    public function sendConnectData($client_id)
    {
        // 赋值给属性
        $this->client_id = $client_id;

        // 主体数据内容
        $this->sn = $this->createRandomUniqueCode();       // 生成sn
        $result_content = 'MN='.$this->sn . ';DATE=' . date('Ymd', time()).'&&';

        // CRC16加密
        $crc = $this->CRC_16($result_content, strlen($result_content));
        $validate_code = strtoupper(base_convert($crc, 10, 32));
        // 最终数据，含包头包尾
        $result_all = '##'.str_pad(strlen($result_content), 4, 0, 0).$result_content.$validate_code.'\r\n';
        return $result_all;
    }



}