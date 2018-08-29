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
            $table->string('sn')->unique()->nullable()->comment('设备唯一标识符');
            $table->string('QN')->nullable()->comment('请求编码');
            $table->string('CN')->nullable()->comment('命令编码');
            $table->string('flag')->nullable()->comment('拆分包及应答标志');
            $table->string('a34001_Rtd')->nullable()->comment('扬尘-总悬浮颗粒物');
            $table->string('a34002_Rtd')->nullable()->comment('PM10');
            $table->string('a34004_Rtd')->nullable()->comment('PM2.5');
            $table->string('LA_Rtd')->nullable()->comment('噪音');
            $table->string('a01001_Rtd')->nullable()->comment('温度');
            $table->string('a01002_Rtd')->nullable()->comment('湿度');
            $table->string('a01006_Rtd')->nullable()->comment('气压');
            $table->string('a01007_Rtd')->nullable()->comment('风速');
            $table->string('a01008_Rtd')->nullable()->comment('风向');

            $table->unsignedInteger('a34001_Rtd_pre_warning')->nullable()->comment('扬尘-总悬浮颗粒物-预警');
            $table->unsignedInteger('a34001_Rtd_is_warning')->nullable()->index()->comment('扬尘-总悬浮颗粒物-报警');
            $table->unsignedInteger('a34002_Rtd_pre_warning')->nullable()->comment('PM10预警');
            $table->unsignedInteger('a34002_Rtd_is_warning')->nullable()->index()->comment('PM10报警');
            $table->unsignedInteger('a34004_Rtd_pre_warning')->nullable()->comment('PM2.5预警');
            $table->unsignedInteger('a34004_Rtd_is_warning')->nullable()->index()->comment('PM2.5报警');
            $table->unsignedInteger('LA_Rtd_pre_warning')->nullable()->comment('噪音上限预警');
            $table->unsignedInteger('LA_Rtd_is_warning')->nullable()->index()->comment('噪音上限报警');
            $table->unsignedInteger('a01001_Rtd_high_pre_warning')->nullable()->comment('温度上限预警');
            $table->unsignedInteger('a01001_Rtd_high_is_warning')->index()->nullable()->comment('温度上限报警');
            $table->unsignedInteger('a01001_Rtd_low_pre_warning')->nullable()->comment('温度下限预警');
            $table->unsignedInteger('a01001_Rtd_low_is_warning')->index()->nullable()->comment('温度下限报警');
            $table->unsignedInteger('a01002_Rtd_pre_warning')->nullable()->comment('湿度上限预警');
            $table->unsignedInteger('a01002_Rtd_is_warning')->index()->nullable()->comment('湿度上限报警');
            $table->unsignedInteger('a01006_Rtd_high_pre_warning')->nullable()->comment('气压上限预警');
            $table->unsignedInteger('a01006_Rtd_low_pre_warning')->nullable()->comment('气压下限预警');
            $table->unsignedInteger('a01006_Rtd_high_is_warning')->nullable()->index()->comment('气压上限预警');
            $table->unsignedInteger('a01006_Rtd_low_is_warning')->index()->index()->nullable()->comment('气压下限报警');
            $table->unsignedInteger('a01007_Rtd_pre_warning')->nullable()->comment('风速上限预警');
            $table->unsignedInteger('a01007_Rtd_is_warning')->index()->nullable()->comment('风速上限报警');

            $table->unsignedInteger('pre_warning_status')->nullable()->index()->comment('是否预警');
            $table->unsignedInteger('is_warning_status')->index()->nullable()->index()->comment('是否报警');
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
