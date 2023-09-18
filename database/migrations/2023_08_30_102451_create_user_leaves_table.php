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
        Schema::create('user_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('leave_type_id');
            $table->foreign('leave_type_id')->references('id')->on('leave_types');
            $table->double('count',8,2,2)->nullable();
            // $table->char('annual_leave',2)->default(5);
            // $table->char('odd_even_month',2)->default(1)->comment('เดือนที่ได้รับพักร้อน 1 คือเดือนคี่ 2 คือเดือนคู่');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_leaves');
    }
};
