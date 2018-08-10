<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCranesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cranes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id')->index()->nullable()->comment('所在项目id');
            $table->unsignedInteger('blackbox_id')->index()->nullable()->comment('黑匣子信息id');
            $table->unsignedInteger('right_unit_id')->index()->nullable()->comment('产权单位id');
            $table->unsignedInteger('is_monitor')->index()->nullable()->comment('是否监控');
            $table->unsignedInteger('driver')->index()->nullable()->comment('司机');
            $table->string('record_no')->nullable()->comment('备案编号');
            $table->string('floor_no')->nullable()->comment('楼号');
            $table->string('model')->nullable()->comment('塔吊型号');
            $table->string('record_no')->nullable()->comment('备案编号');
            $table->string('left_no')->nullable()->comment('塔吊出厂编号');
            $table->text('parameters')->nullable()->comment('塔吊参数');
            $table->timestamp('left_at')->nullable()->comment('出厂日期');
            $table->timestamp('produced_at')->nullable()->comment('出厂日期');
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
        Schema::dropIfExists('cranes');
    }
}
