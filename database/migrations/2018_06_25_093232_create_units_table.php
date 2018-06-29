<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('unit_attr_id')->comment('单位属性id');
            $table->unsignedInteger('parent_id')->index()->comment('上级单位id');

            $table->string('unit_no')->comment('单位机构代码');
            $table->string('name')->comment('单位名称');
            $table->string('country')->comment('项目所在国家');
            $table->string('province')->comment('省');
            $table->string('city')->comment('市');
            $table->string('county')->comment('区');
            $table->string('detail')->comment('详细地址')->nullable();
            $table->string('region')->comment('区域')->nullable();
            $table->string('grade')->comment('资质等级')->nullable();
            $table->string('qualification_no')->comment('资质证书编号')->nullable();
            $table->string('safety_permit')->comment('安全生产许可证')->nullable();
            $table->string('concact_person')->comment('联系人')->nullable();
            $table->string('concact_tel')->comment('联系电话')->nullable();
            $table->string('leader')->comment('法人代表')->nullable();
            $table->string('leader_tel')->comment('法人联系电话')->nullable();
            $table->string('company_site')->comment('企业网址')->nullable();
            $table->string('fax')->comment('传真')->nullable();
            $table->string('main_business')->comment('主营业务')->nullable();
            $table->string('remark')->comment('备注')->nullable();

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
        Schema::dropIfExists('units');
    }
}
