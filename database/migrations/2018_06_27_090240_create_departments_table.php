<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('unit_id')->index()->comment('单位id');
            $table->string('name',50)->comment('部门名称');
            $table->string('no',100)->comment('部门编码');
            $table->unsignedInteger('status')->comment('部门名称');
            $table->string('abbreviation',50)->comment('部门简称');
            $table->string('chargeman',50)->comment('部门负责人');
            $table->boolean('has_children')->comment('是否有下级部门');
            $table->boolean('has_leader')->comment('是否有独立法人');
            $table->string('parent_unit')->comment('上级部门');
            $table->string('address',50)->comment('地址');
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
        Schema::dropIfExists('departments');
    }
}
