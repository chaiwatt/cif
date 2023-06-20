<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('code')->unique();
            $table->time('start');
            $table->time('end');
            $table->time('record_start');
            $table->time('record_end');
            $table->time('break_start');
            $table->time('break_end');
            $table->float('duration')->default(8);
            $table->float('break_hour')->default(1);
            $table->float('multiply')->default(1);
            $table->char('base_shift')->nullable();
            $table->char('common_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
};
