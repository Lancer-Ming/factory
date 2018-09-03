<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDustCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dust_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sn')->index()->nullable()->comment('sn唯一标识');
            $table->string('IMEI')->nullable()->comment('设备的IMEI号');
            $table->string('SIM')->nullable()->comment('信用卡');
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
        Schema::dropIfExists('dust_codes');
    }
}
