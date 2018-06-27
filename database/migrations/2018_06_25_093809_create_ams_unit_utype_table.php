<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmsUnitUtypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ams_unit_utype', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('unit_utype_id')->comment('单位分类id');
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
        Schema::dropIfExists('ams_unit_utype');
    }
}
