<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_units', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contract_id')->index()->comment('施工总承包id');
            $table->unsignedInteger('subcontract_id')->index()->comment('分包单位id')->nullable();
            $table->unsignedInteger('build_id')->index()->comment('建设单位id')->nullable();
            $table->unsignedInteger('supervisor_id')->index()->comment('监理单位id')->nullable();
            $table->unsignedInteger('servey_id')->index()->comment('勘察单位id')->nullable();
            $table->unsignedInteger('design_id')->index()->comment('设计单位id')->nullable();
            $table->unsignedInteger('trail_id')->index()->comment('审图单位id')->nullable();
            $table->unsignedInteger('safety_station_id')->index()->comment('安监站id')->nullable();
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
        Schema::dropIfExists('item_units');
    }
}
