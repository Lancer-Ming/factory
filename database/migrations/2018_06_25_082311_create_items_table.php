<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_category_id')->index()->comment('项目类型id')->nullable();
            $table->unsignedInteger('invest_id')->index()->comment('资金来源')->nullable();
            $table->unsignedInteger('build_type_id')->index()->comment('建设方式')->nullable();
            $table->unsignedInteger('structural_type_id')->index()->comment('结构形式')->nullable();


            $table->unsignedInteger('structural_floor')->comment('结构层数')->nullable();
            $table->string('item_no')->comment('监督登记号')->nullable();
            $table->string('project_no')->comment('工程号')->nullable();
            $table->string('country')->comment('项目所在国家')->nullable();
            $table->string('province')->comment('省')->nullable();
            $table->string('city')->comment('市')->nullable();
            $table->string('county')->comment('区')->nullable();
            $table->string('detail')->comment('详细地址')->nullable();
            $table->string('permit_no')->comment('施工许可证号')->nullable();
            $table->double('area', 15, 2)->comment('建筑面积')->nullable();
            $table->decimal('total_amount')->comment('投资总金额')->nullable();
            $table->string('chargeman')->comment('负责人')->nullable();
            $table->string('chargeman_tel')->comment('负责人电话')->nullable();
            $table->string('gps')->comment('gps')->nullable();

            $table->timestamp('received_at')->comment('接收时间')->nullable();
            $table->timestamp('started_at')->comment('开工时间')->nullable();
            $table->timestamp('ended_at')->comment('竣工时间')->nullable();
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
        Schema::dropIfExists('items');
    }
}
