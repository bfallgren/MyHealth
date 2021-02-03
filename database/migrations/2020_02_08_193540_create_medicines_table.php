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
            $table->string('patient');
            $table->string('name');
            $table->string('dosage');
            $table->integer('dailyFreq');
            $table->string('status')->nullable();
            $table->string('sideAffects')->nullable();
            $table->string('precautions')->nullable();
            $table->timestamps();
        });
    

         Schema::table('medicines', function ($table) {
            DB::statement('ALTER TABLE medicines MODIFY COLUMN patient VARCHAR(32)');
            DB::statement('ALTER TABLE medicines MODIFY COLUMN name VARCHAR(32)');
            DB::statement('ALTER TABLE medicines MODIFY COLUMN dosage VARCHAR(8)');
            DB::statement('ALTER TABLE medicines MODIFY COLUMN status VARCHAR(32)');
            DB::statement('ALTER TABLE medicines MODIFY COLUMN sideAffects VARCHAR(32)');
            DB::statement('ALTER TABLE medicines MODIFY COLUMN precautions VARCHAR(80)');
            
      
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
