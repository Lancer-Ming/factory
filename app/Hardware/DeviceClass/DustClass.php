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

        $this->processMessage = $result;
        return $this;
    }

    public function store()
    {
        $this->formatData();
        Crane::insert($this->$processMessage);
    }

}