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
        Schema::create('salary_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payday_detail_id');
            $table->foreign('payday_detail_id')->references('id')->on('payday_details')->onDelete('cascade');
            $table->unsignedBigInteger('company_department_id');
            $table->char('employee',5)->default(0);
            $table->double('sum_salary')->default(0);
            $table->double('sum_overtime')->default(0);
            $table->double('sum_allowance_diligence')->default(0);
            $table->double('sum_income')->default(0);
            $table->double('sum_deduct')->default(0);
            $table->double('sum_social_security')->default(0);
            $table->char('sum_leave',3)->default(0);
            $table->char('sum_absence',3)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_summaries');
    }
};
