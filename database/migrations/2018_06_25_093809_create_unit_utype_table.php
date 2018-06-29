<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitUtypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_utype', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('utype_id')->comment('单位分类一级id');
            $table->unsignedInteger('p_utype_id')->comment('单位分类二级id');
            $table->unsignedInteger('g_p_utype_id')->comment('单位分类三级id');
            $table->unsignedInteger('unit_id')->comment('单位id');
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
        Schema::dropIfExists('unit_utype');
    }
}
