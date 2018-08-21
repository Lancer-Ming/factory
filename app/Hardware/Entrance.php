<?php
namespace App\Hardware;

class Entrance {
    /** 消息
     * @var string
     */
    static $message = "";

    /** 实例
     * @var Object
     */
    static $instance;

    public static function create($name, $message)
    {
        $class = __NAMESPACE__."\\DeviceClass\\".$name."Class";
        static::$instance =  new $class($message);
    }


    /** 当作跳板
     * @param $name
     * @param $arguments
     * @return Object
     */
    public static function __callStatic($name, $arguments)
    {
        static::create($name, ...$arguments);
        return static::$instance;
    }
}