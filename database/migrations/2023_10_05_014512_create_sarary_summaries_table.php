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
        Schema::create('sarary_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payday_detail_id');
            $table->foreign('payday_detail_id')->references('id')->on('payday_details')->onDelete('cascade');
            $table->double('total_salary')->default(0);
            $table->double('total_overtime')->default(0);
            $table->double('total_diligence_allowance')->default(0);
            $table->double('total_deduct')->default(0);
            $table->double('total_income')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sarary_summaries');
    }
};
