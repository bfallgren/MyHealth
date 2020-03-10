<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('primaryDoctor');
            $table->timestamps();
        });
        Schema::table('patients', function ($table) {
            DB::statement('ALTER TABLE patients MODIFY COLUMN name VARCHAR(32)');
            DB::statement('ALTER TABLE patients MODIFY COLUMN primaryDoctor VARCHAR(32)');
            
      
        }); 

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
