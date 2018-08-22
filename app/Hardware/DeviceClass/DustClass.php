<?php
namespace App\Hardware\DeviceClass;

use App\Models\Crane;

class DustClass {
    /** 消息
     * @var string
     */
    protected $message = "";

    protected $processMessage;

    /** 构造接收消息
     * Entrance constructor.
     * @param $message\
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function formatData()
    {

        // a34004-Rtd：PM2.5    a34002-Rtd：PM10    a34001-Rtd：总悬浮颗粒物 TSP    LA-Rtd：噪音
        // a01001-Rtd：温度    a01002-Rtd：湿度   a01006-Rtd：气压   a01007-Rtd：风速   a01008-Rtd：风向
        return $this;
    }

    public function store()
    {
        $puchMsg = substr($this->message, 6, -4);
        return $this->CRC16_Checkout($puchMsg, count($puchMsg));
        $this->formatData();

        Crane::insert($this->$processMessage);
    }

    /**CRC16 循环冗余校验算法
     * @param $puchMsg 需要校验的字符串指针
     * @param $usDataLen 要校验的字符串长度
     * @return int 返回 CRC16 校验码
     */
    public function  CRC16_Checkout($puchMsg, $usDataLen)
    {
        $crc_reg =  0xFFFF;
        for ($i = 0; $i < $usDataLen; $i++) {
            $crc_reg = ($crc_reg >> 8) ^ $puchMsg[i];
            for ($j = 0; $j < 8; $j++) {
                $check = $crc_reg & 0x0001;
                $crc_reg = $crc_reg >> 1;

                if ($check == 0x0001) {
                    $crc_reg ^= 0xA001;
                }

            }
        }
        return $crc_reg;
    }

}