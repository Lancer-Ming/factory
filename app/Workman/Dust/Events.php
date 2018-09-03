<?php

namespace App\Workerman\Dust;

use App\Hardware\Entrance;
use GatewayWorker\Lib\Gateway;

class Events
{

    public static function onWorkerStart($businessWorker)
    {
    }

    public static function onConnect($client_id)
    {
        // 向所有人发送
        Gateway::sendToAll("$client_id login\n");
    }

    public static function onWebSocketConnect($client_id, $data)
    {
    }

    public static function onMessage($client_id, $message)
    {
        // 获取扬尘处理的实例
        $dust = Entrance::Dust($message);
        // 判断状态并且存储数据
        $dust->store(10000);
        // 获取要发送给硬件的数据
//        $message = $dust->sendConnectData($client_id);
        // 改变 dust 的状态
        $dust->changeStatus();
        // 发送数据sn
//        Gateway::sendToClient($client_id, $message);
        // 向所有人发送
        Gateway::sendToClient($client_id, $message);
    }

    public static function onClose($client_id)
    {
    }
}