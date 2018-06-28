<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmsStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ams_staff', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('staff_cert_type')->index()->comment('员工证件类型');
            $table->unsignedInteger('staff_type')->index()->comment('人员类别');
            $table->unsignedInteger('unit_id')->index()->comment('所属单位id');
            $table->unsignedInteger('department_id')->index()->comment('所属部门id')->nullable();
            $table->unsignedInteger('work_department_id')->index()->comment('工作部门id')->nullable();
            $table->unsignedInteger('team_id_one')->index()->comment('班组1');
            $table->unsignedInteger('team_id_two')->index()->comment('班组2')->nullable();
            $table->unsignedInteger('work_type_id_one')->index()->comment('工种1');
            $table->unsignedInteger('work_type_id_two')->index()->comment('工种2')->nullable();
            $table->unsignedInteger('work_type_id_three')->index()->comment('工种3')->nullable();
            $table->unsignedInteger('staff_extend_id')->index()->comment('扩展信息表id');
            $table->string('realname', '20')->comment('员工姓名');
            $table->unsignedInteger('sex')->comment('员工性别')->nullable();
            $table->string('cert_no')->comment('证件号码');
            $table->string('effective_time', 50)->comment('有效时间')->nullable();
            $table->text('cert_address')->comment('证件地址')->nullable();
            $table->timestamp('birth_time')->comment('出生日期')->nullable();
            $table->string('phone')->comment('手机号码');
            $table->integer('is_certificated')->index()->comment('人员认证是否')->nullable();
            $table->string('sign_orgarization')->comment('签发机关')->nullable();
            $table->integer('is_trained')->index()->comment('是否培训')->nullable();
            $table->string('current_address')->comment('现居住地址')->nullable();
            $table->integer('age')->comment('年龄')->nullable();
            $table->integer('education')->comment('学历')->nullable();
            $table->integer('nation')->comment('名族')->nullable();
            $table->string('emergency_contact_person')->comment('紧急联系人')->nullable();
            $table->string('emergency_contact_tel')->comment('紧急联系电话')->nullable();
            $table->integer('native_place')->comment('籍贯')->nullable();
            $table->string('skill_one')->comment('等级技能1')->nullable();
            $table->string('skill_two')->comment('等级技能2')->nullable();
            $table->string('skill_three')->comment('等级技能3')->nullable();
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
        Schema::dropIfExists('ams_staff');
    }
}
