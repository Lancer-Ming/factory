<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ys_id')->nullable()->index()->comment('萤石用户表外键id');
            $table->string('d_name', 60)->nullable()->index()->comment('设备名称');
            $table->string('serial')->nullable()->index()->comment('设备序列号');
            $table->integer('channel_no')->nullable()->comment('设备通道号');
            $table->string('validate_code')->nullable()->comment('设备验证码，设备机身上的六位大写字母');
            $table->timestamp('install_at')->nullable()->comment('安装日期');
            $table->string('chargeman')->nullable()->comment('负责人');
            $table->string('chargeman_tel')->nullable()->comment('负责人手机号');
            $table->string('hls')->nullable()->comment('HLS播放地址');
            $table->string('hlsHd')->nullable()->comment('HLS播放地址(高清)');
            $table->string('rtmp')->nullable()->comment('RTMP播放地址');
            $table->string('rtmpHd')->nullable()->comment('RTMP播放地址(高清)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
