<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patientID');
            $table->date('testDate');
            $table->string('component',24);
            $table->float('measuredValue',6,2);
            $table->string('goodRange',24)->nullable();
            $table->string('comments',512)->nullable();
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
        Schema::dropIfExists('labs');
    }
}
