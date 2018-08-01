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
            $table->string('appkey')->nullabel()->comment('萤石云AppKey');
            $table->string('secret')->nullabel()->comment('萤石云Secret');
            $table->string('access_token')->nullabel()->comment('萤石云AccessToken');
            $table->string('username')->nullabel()->comment('萤石云账号');
            $table->string('password')->nullabel()->comment('萤石云密码');
            $table->string('phone')->nullabel()->comment('手机号');
            $table->unsignedInteger('expiretime')->nullabel()->comment('有效期时间戳');
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
