<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('employee_no',50)->nullable()->comment('รหัสพนักงาน');
            $table->unsignedBigInteger('prefix_id')->nullable()->comment('คำนำหน้าชื่อ');
            $table->string('name',50)->comment('ชื่อ');
            $table->string('lastname',50)->nullable()->comment('นามสกุล');
            $table->unsignedBigInteger('company_department_id')->nullable()->comment('แผนกทำงาน');
            $table->unsignedBigInteger('user_position_id')->nullable()->comment('ตำแหน่งงาน');
            $table->unsignedBigInteger('employee_type_id')->nullable()->comment('ประเภทพนักงาน');
            $table->unsignedBigInteger('nationality_id')->nullable()->comment('สัญชาติ');
            $table->unsignedBigInteger('ethnicity_id')->nullable()->comment('เชื้อชาติ');
            $table->string('address',250)->nullable()->comment('ที่อยู่');
            $table->char('phone',50)->nullable()->comment('เบอร์โทรศัพท์');
            $table->string('hid',13)->nullable()->comment('เลขที่บัตรประจำตัวประชาชน');
            $table->string('passport',20)->nullable()->comment('พาสพอร์ต');
            $table->string('work_permit',20)->nullable()->comment('เอกสารอนุญาตทำงาน');
            $table->date('start_work_date')->nullable()->comment('วันที่เริ่มทำงาน');
            $table->date('birth_date')->nullable()->comment('วันเดือนปี เกิด');
            $table->date('visa_expiry_date')->nullable()->comment('วันหมดอายุวีซ่า');
            $table->date('permit_expiry_date')->nullable()->comment('วันหมดอายุใบอนุญาตทำงาน');
            $table->string('email',50)->unique()->comment('อีเมล');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('tax')->nullable();
            $table->string('education_level')->nullable()->comment('ระดับการศึกษา');
            $table->string('education_branch')->nullable()->comment('สาขาวิชา');
            $table->string('bank')->nullable()->comment('บัญชีธนาคาร');
            $table->string('bank_account')->nullable()->comment('เลขที่บัญชีธนาคาร');
            $table->char('is_admin',1)->default(0);
            $table->unsignedBigInteger('work_schedule_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
