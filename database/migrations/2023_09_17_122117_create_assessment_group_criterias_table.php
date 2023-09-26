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
        Schema::create('assessment_group_criterias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_group_id');
            $table->unsignedBigInteger('accessment_criteria_id');
            $table->unsignedBigInteger('assessment_score_multiplication_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_group_criterias');
    }
};
