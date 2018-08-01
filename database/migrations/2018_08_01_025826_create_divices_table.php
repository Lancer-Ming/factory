<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ys_id')->nullabel()->index()->comment('萤石用户表外键id');
            $table->string('d_name', 60)->nullabel()->index()->comment('设备名称');
            $table->string('serial')->nullabel()->comment('设备序列号');
            $table->string('channel_no')->nullabel()->comment('设备通道号');
            $table->string('validate_code')->nullabel()->comment('设备验证码，设备机身上的六位大写字母');
            $table->timestamp('install_at')->nullabel()->comment('安装日期');
            $table->string('chargeman')->nullabel()->comment('负责人');
            $table->string('chargeman_tel')->nullabel()->comment('负责人手机号');
            $table->string('ezopen')->nullable()->comment('EZOPEN直播源');
            $table->string('hls_address')->nullable()->comment('HLS播放地址');
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
        Schema::dropIfExists('divices');
    }
}
