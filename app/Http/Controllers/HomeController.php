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
        $id = DB::table('codes')->insertGetId(['code' => 12, 'type' => 2]);
        dd($id);
        $message = "QN=20180906103406000;ST=39;CN=2011;PW=123456;MN=690000D5800028F889000003;Flag=4;CP=&&DataTime=20180906103406;a34004-Rtd=45.0;a34002-Rtd=62.7;a34001-Rtd=78.4;LA-Rtd=63.2;a01001-Rtd=28.3;a01002-Rtd=60.0;a01006-Rtd=100.3;a01007-Rtd=0.0;a01008-Rtd=45&&";
        $puchMsg = $message;
        $usDataLen = strlen($message);
        $crc = $this->CRC_16($puchMsg, $usDataLen);
        return strtoupper(base_convert($crc, 10, 16));
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
        $message = "QN=20180906103406000;ST=39;CN=2011;PW=123456;MN=690000D5800028F889000003;Flag=4;CP=&&DataTime=20180906103406;a34004-Rtd=45.0;a34002-Rtd=62.7;a34001-Rtd=78.4;LA-Rtd=63.2;a01001-Rtd=28.3;a01002-Rtd=60.0;a01006-Rtd=100.3;a01007-Rtd=0.0;a01008-Rtd=45&&";
        $this->message = str_replace(array("\r\n", "\r", "\n"),"", $message);
        $validateCode = substr($this->message, -4);
        $puchMsg = $message;
        $usDataLen = strlen($message);
        $crc = $this->CRC_16($puchMsg, $usDataLen);
        return strtoupper(base_convert($crc, 10, 16));
    }
}
