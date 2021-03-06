<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsFormedToUtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('utypes', function (Blueprint $table) {
            $table->string('form_name')->nullable()->index()->comment('在其他表单用到的单位的字段名');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('utypes', function (Blueprint $table) {
            $table->dropColumn('form_name');
        });
    }
}
