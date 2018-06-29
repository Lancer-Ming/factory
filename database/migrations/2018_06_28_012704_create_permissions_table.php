<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->index()->comment('父级关系id');
            $table->string('icon', 30)->comment('图标')->nullable();
            $table->string('name')->comment('路由名');
            $table->unsignedInteger('sort')->index()->comment('排序')->default(100);
            $table->string('label', 20)->comment('操作权限名称');
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
        Schema::dropIfExists('permissions');
    }
}
