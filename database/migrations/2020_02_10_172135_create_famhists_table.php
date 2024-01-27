<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamhistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('famhists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patientID');
            $table->string('familyMember',16);
            $table->string('relation',16);
            $table->string('symptoms',256);
            $table->string('comments',256)->nullable();
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
        Schema::dropIfExists('famhists');
    }
}
