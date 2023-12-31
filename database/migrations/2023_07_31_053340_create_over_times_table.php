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
        Schema::create('over_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('approver_id');
            $table->foreign('approver_id')->references('id')->on('approvers')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->char('manager_approve',1)->default(0);
            $table->string('approved_list')->nullable();
            $table->char('type',1)->default(1);
            $table->char('status',1)->default(0);
            $table->char('manual_time',1)->default(1);
            $table->char('hour_duration',2)->default(4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('over_times');
    }
};
