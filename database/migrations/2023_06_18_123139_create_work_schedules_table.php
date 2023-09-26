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
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('ชื่อตารางทำงาน');
            $table->char('year',4)->comment('ปีตารางการทำงาน');
            $table->string('description')->nullable()->comment('คำอธิบายตารางทำงาน');
            $table->unsignedBigInteger('schedule_type_id')->default(1)->comment('ประเภทตารางทำงาน เต็มเดือน 0 เวียนกะ 1');
            // $table->char('auto_overtime',1)->default(1)->comment('1 = ไม่ , 2 = ใช่');
            // $table->char('duration',2)->default(3)->comment('จำนวนชั่วโมงล่วงเวลา');
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
        Schema::dropIfExists('work_schedules');
    }
};
