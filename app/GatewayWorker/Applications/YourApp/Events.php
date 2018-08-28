<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
use App\Hardware\Entrance;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        Gateway::sendToClient($client_id, json_encode(array(
            'type' => 'init',
            'client_id' => $client_id
        )));
    }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
    public static function onMessage($client_id, $message)
    {
        GateWay::sendToAll(json_encode(array(
            'type' => 'message',
            'client_id' => $client_id,
            'message' => $message
        )));
//        // 向人发送
//        Gateway::sendToClient($client_id, 'ok');
//        // 获取扬尘处理的实例
//        $dust = Entrance::Dust();
//        // 判断状态并且存储数据
//        $dust->store($client_id);
//        // 获取要发送给硬件的数据
//        $message = $dust->sendConnectData($client_id);
//        // 改变 dust 的状态
//        $dust->changeStatus();
//        // 发送数据sn
//        Gateway::sendToClient($client_id, $message);

    }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id)
   {
       // 向所有人发送
       GateWay::sendToAll(json_encode(array(
           'type' => 'logout',
           'client_id' => $client_id
       )));
   }
}
