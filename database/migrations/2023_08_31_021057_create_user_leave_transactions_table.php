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
        Schema::create('user_leave_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_leave_id');
            $table->foreign('user_leave_id')->references('id')->on('user_leaves')->onDelete('cascade');
            $table->unsignedBigInteger('month_id');
            $table->foreign('month_id')->references('id')->on('months');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_leave_transactions');
    }
};
