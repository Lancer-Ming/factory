<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('appkey')->nullable()->comment('萤石云AppKey');
            $table->string('secret')->nullable()->comment('萤石云Secret');
            $table->string('access_token')->nullable()->comment('萤石云AccessToken');
            $table->string('username')->nullable()->comment('萤石云账号');
            $table->string('password')->nullable()->comment('萤石云密码');
            $table->string('phone')->nullable()->comment('手机号');
            $table->unsignedInteger('expiretime')->nullable()->comment('有效期时间戳');
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
        Schema::dropIfExists('ys');
    }
}
