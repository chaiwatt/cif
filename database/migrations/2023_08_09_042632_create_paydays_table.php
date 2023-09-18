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
        Schema::create('paydays', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->char('cross_month',1)->default(0);
            $table->char('start_day',2)->nullable();
            $table->char('end_day',2)->nullable();
            $table->char('payment_type',1)->default(1);
            $table->char('duration',2)->default(7);
            $table->char('type',1)->default(1);
            $table->char('year',4)->nullable();
            $table->unsignedBigInteger('first_payday_id')->nullable();
            $table->unsignedBigInteger('second_payday_id')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paydays');
    }
};
