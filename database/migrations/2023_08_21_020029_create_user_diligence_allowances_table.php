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
        Schema::create('user_diligence_allowances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('payday_detail_id');
            $table->foreign('payday_detail_id')->references('id')->on('payday_details')->onDelete('cascade');
            $table->unsignedBigInteger('diligence_allowance_classify_id')->nullable();
            $table->foreign('diligence_allowance_classify_id', 'fk_wsa_user_diligence_allowances_classify_id')->references('id')->on('diligence_allowance_classifies')->onDelete('cascade');
            $table->timestamps();
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_diligence_allowances');
    }
};
