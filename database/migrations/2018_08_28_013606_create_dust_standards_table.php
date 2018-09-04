<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDustStandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dust_standards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sn')->unique()->nullable()->comment('sn唯一标识');

            $table->string('a34001_Rtd_pre_warning')->nullable()->comment('扬尘-总悬浮颗粒物-预警');
            $table->string('a34001_Rtd_is_warning')->nullable()->comment('扬尘-总悬浮颗粒物-报警');
            $table->string('a34002_Rtd_pre_warning')->nullable()->comment('PM10预警');
            $table->string('a34002_Rtd_is_warning')->nullable()->comment('PM10报警');
            $table->string('a34004_Rtd_pre_warning')->nullable()->comment('PM2.5预警');
            $table->string('a34004_Rtd_is_warning')->nullable()->comment('PM2.5报警');
            $table->string('LA_Rtd_pre_warning')->nullable()->comment('噪音上限预警');
            $table->string('LA_Rtd_is_warning')->nullable()->comment('噪音上限报警');
            $table->string('a01001_Rtd_high_pre_warning')->nullable()->comment('温度上限预警');
            $table->string('a01001_Rtd_high_is_warning')->nullable()->comment('温度上限报警');
            $table->string('a01001_Rtd_low_pre_warning')->nullable()->comment('温度下限预警');
            $table->string('a01001_Rtd_low_is_warning')->nullable()->comment('温度下限报警');
            $table->string('a01002_Rtd_pre_warning')->nullable()->comment('湿度上限预警');
            $table->string('a01002_Rtd_is_warning')->nullable()->comment('湿度上限报警');
            $table->string('a01006_Rtd_high_pre_warning')->nullable()->comment('气压上限预警');
            $table->string('a01006_Rtd_low_pre_warning')->nullable()->comment('气压下限预警');
            $table->string('a01006_Rtd_high_is_warning')->nullable()->comment('气压下限预警');
            $table->string('a01006_Rtd_low_is_warning')->nullable()->comment('气压下限报警');
            $table->string('a01007_Rtd_pre_warning')->nullable()->comment('风速上限预警');
            $table->string('a01007_Rtd_is_warning')->nullable()->comment('风速上限报警');
            $table->text('remark')->nullable()->comment('备注');
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
        Schema::dropIfExists('dust_standards');
    }
}
