<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVaccinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('patientName');
            $table->date('vDate');
            $table->string('vaccine');
            $table->string('comments')->nullable();
            $table->timestamps();
        });

        Schema::table('vaccines', function ($table) {
        DB::statement('ALTER TABLE vaccines MODIFY COLUMN patientName VARCHAR(32)');
        DB::statement('ALTER TABLE vaccines MODIFY COLUMN vaccine VARCHAR(24)');
        DB::statement('ALTER TABLE vaccines MODIFY COLUMN comments VARCHAR(512)');
      
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccines');
    }
}
