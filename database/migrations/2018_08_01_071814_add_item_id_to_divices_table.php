<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemIdToDivicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('divices', function (Blueprint $table) {
            $table->unsignedInteger('item_id')->index()->comment('关联项目id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('divices', function (Blueprint $table) {
            $table->dropColumn('item_id');
        });
    }
}
