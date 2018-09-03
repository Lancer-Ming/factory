<?php

namespace App\Console\Commands;

use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Illuminate\Console\Command;
use Workerman\Worker;

class WorkmanDustCommond extends Command {
    protected $signature = 'workman {action} {--d}';

    protected $description = 'Start a Workerman server.';

    public function handle()
    {
        global $argv;
        $action = $this->argument('action');

        $argv[0] = 'wk';
        $argv[1] = $action;
        $argv[2] = $this->option('d') ? '-d' : '';

        $this->start();
    }

    private function start()
    {
        $this->startGateWay();
        $this->startBusinessWorker();
        $this->startRegister();
        Worker::runAll();
    }

    private function startBusinessWorker()
    {
        $worker                  = new BusinessWorker();
        $worker->name            = 'DustWorker';
        $worker->count           = 4;
        $worker->registerAddress = '0.0.0.0:1238';
        $worker->eventHandler    = \App\Workerman\Dust\Events::class;
    }

    private function startGateWay()
    {
        $gateway = new Gateway("tcp://0.0.0.0:8282");
        $gateway->name                 = 'DustGateway';
        $gateway->count                = 4;
        $gateway->lanIp                = '127.0.0.1';
        $gateway->startPort            = 2900;
        $gateway->pingInterval         = 30;
        $gateway->pingNotResponseLimit = 0;
        $gateway->pingData             = '{"type":"@heart@"}';
        $gateway->registerAddress      = '127.0.0.1:1238';
    }

    private function startRegister()
    {
        new Register('text://0.0.0.0:1238');
    }
}