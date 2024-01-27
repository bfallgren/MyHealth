<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabtemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labtemplates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patientID');
            $table->string('tmplName',24);  
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
        Schema::dropIfExists('labtemplates');
    }
}
