<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmsStaffExtendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ams_staff_extends', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('contract_handled')->comment('合同是否办理')->nullable();
            $table->timestamp('contract_handled_at')->comment('办理日期')->nullable();
            $table->string('contract_no')->comment('合同编号')->nullable();
            $table->timestamp('contract_invalid_at')->comment('办理失效日期')->nullable();
            $table->string('contract_original')->comment('合同原件')->nullable();

            $table->boolean('special_cert_handled')->comment('是否有特种证书')->nullable();
            $table->unsignedInteger('special_cert_name')->comment('证书名称')->nullable();
            $table->timestamp('special_cert_handled_at')->comment('证书办理日期')->nullable();
            $table->timestamp('special_cert_invalid_at')->comment('证书有效日期')->nullable();
            $table->string('special_cert_appendix')->comment('证书附件')->nullable();
            $table->string('special_cert_unit')->comment('证书签发单位')->nullable();

            $table->boolean('safety_insurance')->comment('安全保险')->nullable();
            $table->boolean('educational_card')->comment('教育卡')->nullable();
            $table->timestamp('educational_card_created_at')->comment('建卡日期')->nullable();
            $table->float('education_score')->comment('安全教育成绩')->nullable();
            $table->string('entrance_guard',40)->comment('门禁卡号')->nullable();
            $table->string('entrance_guard_no',40)->comment('门禁卡编号')->nullable();
            $table->string('epc_no',40)->comment('EPC编号')->nullable();
            $table->string('location_card_no',40)->comment('定位卡号')->nullable();

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
        Schema::dropIfExists('ams_staff_extends');
    }
}
