<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmsItemManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ams_item_manager', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id')->index()->comment('项目id');
            $table->unsignedInteger('admin_id')->index()->comment('管理人员id');
            $table->string('realname')->comment('管理人员姓名')->nullable();
            $table->string('company')->comment('管理人员单位名称')->nullable();
            $table->string('occupation')->comment('管理人员职位')->nullable();
            $table->string('tel')->comment('管理人员联系电话')->nullable();
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
        Schema::dropIfExists('ams_item_manager');
    }
}
