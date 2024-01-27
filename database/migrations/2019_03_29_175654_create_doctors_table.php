<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',32);
            $table->integer('patientID');
            $table->string('specialty',32);
            $table->string('location',36)->nullable();
            $table->string('hospital',36)->nullable();
            $table->boolean('active')->nullable();
            $table->integer('doctorRating')->nullable();
            $table->integer('staffRating')->nullable();
            $table->string('services',64)->nullable();
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
        Schema::dropIfExists('doctors');
    }
}
