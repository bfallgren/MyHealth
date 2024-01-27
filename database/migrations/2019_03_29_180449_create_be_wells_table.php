<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeWellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('be_wells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patientID');
            $table->date('apptDate');
            $table->string('doctorName',32);
            $table->string('doctorSpecialty',24);
            $table->integer('fee')->nullable();
            $table->string('reason',80)->nullable();
            $table->string('diagnosis',512)->nullable();
            $table->integer('vitalsWeight')->nullable();
            $table->string('vitalsBP',16)->nullable();
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
        Schema::dropIfExists('be_wells');
    }
}
