<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->float('record_start',8,1)->default(2.0);
            $table->float('record_end',8,1)->default(6.5);
            $table->time('break_start');
            $table->time('break_end');
            $table->unsignedBigInteger('shift_type_id');
            $table->float('duration')->default(8);
            $table->float('break_hour')->default(1);
            $table->float('multiply')->default(1);
            $table->char('base_shift')->nullable();
            $table->char('common_code')->nullable();
            $table->char('year', 4)->default(Carbon::now()->year)->nullable();
            $table->string('color')->nullable();
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
