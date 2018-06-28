<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmsPermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ams_permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('permission_id')->index()->comment('权限id');
            $table->unsignedInteger('role_id')->index()->comment('角色id');
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
        Schema::dropIfExists('ams_permission_role');
    }
}
