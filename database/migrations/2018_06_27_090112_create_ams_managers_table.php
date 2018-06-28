<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmsManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ams_managers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('team_id')->index()->comment('班组');
            $table->unsignedInteger('unit_id')->index()->comment('所属单位id');
            $table->unsignedInteger('department_id')->index()->comment('所属部门id')->nullable();
            $table->unsignedInteger('work_department_id')->index()->comment('工作部门id')->nullable();
            $table->unsignedInteger('job_id')->index()->comment('职位id')->nullable();

            $table->string('realname', 10)->comment('姓名');
            $table->unsignedInteger('manager_cert_type')->index()->comment('员工证件类型');
            $table->string('cert_no')->comment('证件号码');
            $table->unsignedInteger('nation')->comment('名族')->nullable();
            $table->unsignedInteger('native_place')->comment('籍贯')->nullable();
            $table->timestamp('birth_time')->comment('出生日期')->nullable();
            $table->unsignedInteger('education')->comment('学历')->nullable();
            $table->unsignedInteger('political')->comment('政治面貌')->nullable();
            $table->unsignedInteger('sex')->comment('性别')->nullable();
            $table->unsignedInteger('marital_status')->comment('婚姻状况')->nullable();
            $table->unsignedInteger('age')->comment('年龄')->nullable();
            $table->unsignedInteger('manager_type')->comment('人员类型');
            $table->string('manager_num', 30)->comment('人员序号');
            $table->string('sign_orgarization')->comment('签发机关')->nullable();
            $table->timestamp('valided_at')->comment('有效时间')->nullable();
            $table->string('major')->comment('专业')->nullable();
            $table->string('graduate')->comment('毕业学校')->nullable();
            $table->string('graduated_at')->comment('毕业日期')->nullable();
            $table->string('work_tel_one')->comment('工作电话1')->nullable();
            $table->string('work_tel_two')->comment('工作电话2')->nullable();
            $table->string('work_tel_three')->comment('工作电话3')->nullable();
            $table->string('phone_one')->comment('移动电话1');
            $table->string('phone_two')->comment('移动电话2')->nullable();
            $table->string('phone_three')->comment('移动电话3')->nullable();
            $table->unsignedInteger('is_certificated')->index()->comment('人员认证是否')->nullable();
            $table->text('cert_address')->comment('证件地址')->nullable();
            $table->string('current_address')->comment('现居住地址')->nullable();

            $table->string('iris')->comment('虹膜')->nullable();
            $table->string('fingerprint')->comment('指纹')->nullable();
            $table->string('palm_prints')->comment('掌纹')->nullable();

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
        Schema::dropIfExists('ams_managers');
    }
}
