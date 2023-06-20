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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->string('address',250)->nullable();
            $table->string('soi',100)->nullable();
            $table->string('road',100)->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('amphur_id')->nullable();
            $table->unsignedBigInteger('tambol_id')->nullable();
            $table->char('phone', 10)->nullable();
            $table->char('fax', 10)->nullable();
            $table->char('commercial_registration', 20)->nullable();
            $table->char('tax', 20)->nullable();
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
        Schema::dropIfExists('companies');
    }
};
