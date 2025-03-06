<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patientID');
            $table->string('name',32);
            $table->string('dosage',8);
            $table->integer('dailyFreq');
            $table->string('status',80)->nullable();
            $table->string('sideAffects',32)->nullable();
            $table->string('notes',255)->nullable();
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
        Schema::dropIfExists('medicines');
    }
}
