<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('work_schedule_assignment_user_files', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('work_schedule_assignment_user_id');
        //     $table->foreign('work_schedule_assignment_user_id')->references('id')->on('work_schedule_assignment_users')->onDelete('cascade');
        //     $table->text('file')->nullable();
        //     $table->timestamps();
        // });

        Schema::create('work_schedule_assignment_user_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_schedule_assignment_user_id');

            // Specify a custom name for the foreign key constraint
            $table->foreign('work_schedule_assignment_user_id', 'fk_wsa_user_id')->references('id')->on('work_schedule_assignment_users')->onDelete('cascade');

            $table->text('file')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_schedule_assignment_user_files');
    }
};
