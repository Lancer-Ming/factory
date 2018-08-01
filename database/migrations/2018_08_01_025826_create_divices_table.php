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
            $table->unsignedInteger('ys_id')->index()->comment('萤石用户表外键id');
            $table->string('d_name', 60)->index()->comment('设备名称');
            $table->string('serial')->comment('设备序列号');
            $table->string('validate_code')->comment('设备验证码，设备机身上的六位大写字母');
            $table->string('ezopen')->comment('EZOPEN直播源');
            $table->string('hls_address')->comment('HLS播放地址');
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
