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
        Schema::create('work_schedule_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_schedule_id');
            $table->foreign('work_schedule_id')->references('id')->on('work_schedules')->onDelete('cascade');
            $table->char('week_day',1)->nullable();    
            $table->char('day',2); 
            $table->char('month',2); 
            $table->char('year',4); 
            $table->unsignedBigInteger('shift_id')->nullable();  
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
        Schema::dropIfExists('work_schedule_assignments');
    }
};
