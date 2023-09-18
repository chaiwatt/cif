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
        Schema::create('work_schedule_assignment_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_schedule_assignment_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('work_schedule_assignment_id', 'wsa_user_assignment_foreign')->references('id')->on('work_schedule_assignments')->onDelete('cascade');
            $table->foreign('user_id', 'wsa_user_user_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->date('date_in')->nullable();
            $table->time('time_in')->nullable();
            $table->date('date_out')->nullable();
            $table->time('time_out')->nullable();
            $table->string('original_time')->nullable();
            $table->string('code')->nullable();
            $table->timestamps();

            // Add indexes
            $table->index('work_schedule_assignment_id');
            $table->index('user_id');
            // Use a composite index
            // $table->index(['work_schedule_assignment_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_schedule_assignment_users');
    }
};
