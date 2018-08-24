<?php

namespace App\Hardware\DeviceClass;

use App\Models\Code;
use App\Models\Crane;

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
     * @return DustClass|array|void
     */
    public function store()
    {
        // 检验
        if (!$this->CRC_16_Check()) {
            return;
        }

        // 将数据进行格式化
        $this->formatData();

        // 将数据储存
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
            $mmdd = date('md', time());
            $hostCode = $code.$mmdd;

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

    public function sendConnectData()
    {
        return $result_code = $this->createRandomUniqueCode() . ';' . date('Ymd', time());
    }



}