<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDustInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dust_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dust_id')->index()->nullable()->comment('扬尘id');
            $table->string('MN')->index()->nullable()->comment('设备唯一标识符');
            $table->string('QN')->nullable()->comment('请求编码');
            $table->string('CN')->nullable()->comment('命令编码');
            $table->string('flag')->nullable()->comment('拆分包及应答标志');
            $table->string('a34001-Rtd')->nullable()->comment('扬尘-总悬浮颗粒物');
            $table->string('a34002-Rtd')->nullable()->comment('PM10');
            $table->string('a34004-Rtd')->nullable()->comment('PM2.5');
            $table->string('LA-Rtd')->nullable()->comment('噪音');
            $table->string('a01001-Rtd')->nullable()->comment('温度');
            $table->string('a01002-Rtd')->nullable()->comment('湿度');
            $table->string('a01006-Rtd')->nullable()->comment('气压');
            $table->string('a01007-Rtd')->nullable()->comment('风速');
            $table->string('a01008-Rtd')->nullable()->comment('风向');
            $table->timestamp('received_at')->nullable()->comment('时间');
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
        Schema::dropIfExists('dust_infos');
    }
}
