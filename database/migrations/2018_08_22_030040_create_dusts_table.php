<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDustsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dusts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id')->index()->nullable()->comment('所在项目id');
            $table->unsignedInteger('right_id')->index()->nullable()->comment('产权单位id');
            $table->unsignedInteger('install_id')->index()->nullable()->comment('安装单位id');
            $table->unsignedInteger('is_monitor')->index()->nullable()->comment('是否监控');
            $table->unsignedInteger('is_online')->index()->nullable()->comment('在线状态');
            $table->string('monitor_place_name')->nullable()->comment('监控点名称');
            $table->string('sn')->unique()->nullable()->comment('SN');
            $table->string('pre_warn_count')->index()->nullable()->comment('预警数');
            $table->string('cur_warn_count')->index()->nullable()->comment('报警数');
            $table->string('d_model')->nullable()->comment('设备型号');
            $table->timestamp('installed_at')->nullable()->comment('安装日期');
            $table->timestamp('disassembled_at')->nullable()->comment('拆卸日期');
            $table->string('SIM_card')->nullable()->comment('SIM');
            $table->unsignedInteger('valid_month')->nullable()->comment('有效期（月）');
            $table->timestamp('paid_at')->nullable()->comment('缴费日期');
            $table->text('func_config')->nullable()->comment('功能配置');
            $table->string('remark')->nullable()->comment('备注');
            $table->string('machanical_type')->nullable()->comment('备注');
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
        Schema::dropIfExists('dusts');
    }
}
