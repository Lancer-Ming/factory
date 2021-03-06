<?php

namespace App\Workerman\Dust;

use App\Hardware\Entrance;
use GatewayWorker\Lib\Gateway;

class Events
{
    public static function onConnect($client_id)
    {
        // 向所有人发送
        Gateway::sendToAll("$client_id login\n");
    }

    public static function onMessage($client_id, $message)
    {
        // 获取扬尘处理的实例
        $dust = Entrance::Dust($message);
        // 判断状态并且存储数据
        $dust->store($client_id);
        // 获取要发送给硬件的数据
        $message = $dust->sendConnectData($client_id);
        // 发送数据sn
//        Gateway::sendToClient($client_id, $message);
        // 向所有人发送
        Gateway::sendToAll($message);
    }

    public static function onClose($client_id)
    {
        $dust = Entrance::Dust();
        $dust->insertCloseTime($client_id);
    }

}