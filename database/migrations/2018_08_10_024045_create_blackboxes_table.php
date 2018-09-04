<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlackboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blackboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('install_unit_id')->index()->nullable()->comment('安装单位id');
            $table->unsignedInteger('crane_id')->index()->nullable()->comment('塔机id');
            $table->string('sn')->index()->nullable()->comment('黑匣子SN');
            $table->string('GPRS')->index()->nullable()->comment('黑匣子GPRS');
            $table->unsignedInteger('validity_month')->index()->nullable()->comment('有效日期');
            $table->unsignedInteger('model')->nullable()->comment('黑匣子型号');
            $table->timestamp('paid_at')->nullable()->comment('续费日期');
            $table->timestamp('installed_at')->nullable()->comment('安装日期');
            $table->text('function_config')->nullable()->comment('功能配置');
            $table->text('identify')->nullable()->comment('身份识别');
            $table->string('height')->nullable()->comment('高度');
            $table->string('range')->nullable()->comment('幅度');
            $table->string('rotation')->nullable()->comment('回转');
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
        Schema::dropIfExists('blackboxes');
    }
}
