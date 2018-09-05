<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Cache;

use App\Hardware\Entrance;

class HomeController extends Controller
{
    protected $message;
    public function index()
    {
        return view('index', compact('permissions'));
    }

    public function api()
    {
        return view('api');
    }

    public function test()
    {
        return view('test');
    }

    public function gateway()
    {
        $standard = DB::select('select IMEI from ams_dust_codes where sn = ?', ['000001']);
        dd($standard);
        $standard = $standard ? $standard[0] : [];

    }

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

    protected function gateTest()
    {
        $message = "##0091QN=20180904160638000;ST=39;CN=2011;PW=123456;USCC=91440101MA59F70720;IMEI=867732039951777&&B8C1";
        $message = "##0035SN=271909;DATETIME=20180904163444&&";
        $this->message = str_replace(array("\r\n", "\r", "\n"),"", $message);
        $validateCode = substr($this->message, -4);
        $puchMsg = substr($this->message, 6, -4);
        $usDataLen = strlen($puchMsg);
        $crc = $this->CRC_16($puchMsg, $usDataLen);
        return strtoupper(base_convert($crc, 10, 16));
        // 获取扬尘处理的实例
        $dust = Entrance::Dust($message);
        // 判断状态并且存储数据
        $dust->store();
        // 获取要发送给硬件的数据
//        $message = $dust->sendConnectData($client_id);
        // 改变 dust 的状态
        $dust->changeStatus();
    }
}
