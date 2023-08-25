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
        Schema::create('diligence_allowance_classifies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diligence_allowance_id');
            $table->foreign('diligence_allowance_id')->references('id')->on('diligence_allowances')->onDelete('cascade');
            $table->char('level',1)->default(1);
            $table->double('cost',8,2,2)->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diligence_allowance_classifies');
    }
};
