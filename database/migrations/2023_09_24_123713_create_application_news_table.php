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
        Schema::create('application_news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            // Add new field
            $table->integer('amount_apply')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date');
            $table->string('application_form')->nullable();
            
            $table->char('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_news');
    }
};
