<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ams_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_category_id')->index()->comment('项目类型id');
            $table->unsignedInteger('invest_id')->index()->comment('资金来源');
            $table->unsignedInteger('build_type_id')->index()->comment('建设方式');
            $table->unsignedInteger('structural_type_id')->index()->comment('结构形式');


            $table->unsignedInteger('structural_floor')->comment('结构层数');
            $table->string('item_no')->comment('监督登记号');
            $table->string('project_no')->comment('工程号');
            $table->string('country')->comment('项目所在国家');
            $table->string('province')->comment('省');
            $table->string('city')->comment('市');
            $table->string('county')->comment('区');
            $table->string('detail')->comment('详细地址');
            $table->string('permit_no')->comment('施工许可证号');
            $table->double('area', 15, 2)->comment('建筑面积');
            $table->decimal('total_amount')->comment('投资总金额');
            $table->string('chargeman')->comment('负责人');
            $table->string('chargeman_tel')->comment('负责人电话');
            $table->string('gps')->comment('gps');

            $table->timestamp('received_at')->comment('接收时间');
            $table->timestamp('started_at')->comment('开工时间');
            $table->timestamp('ended_at')->comment('竣工时间');
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
        Schema::dropIfExists('ams_items');
    }
}
