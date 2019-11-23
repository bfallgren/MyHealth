<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabtests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labtests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('patientName');
            $table->date('testDate');
            $table->string('component');
            $table->FLOAT (6,2)('measuredValue');
            $table->string('goodRange')->nullable();
            $table->string('comments')->nullable();
            $table->timestamps();
        });

     Schema::table('labtests', function ($table) {
        DB::statement('ALTER TABLE labtests MODIFY COLUMN patientName VARCHAR(32)');
        DB::statement('ALTER TABLE labtests MODIFY COLUMN component VARCHAR(24)');
        DB::statement('ALTER TABLE labtests MODIFY COLUMN goodRange VARCHAR(24)');
        DB::statement('ALTER TABLE labtests MODIFY COLUMN comments VARCHAR(512)');
         DB::statement('ALTER TABLE labtests MODIFY COLUMN measuredValue FLOAT(6,2)');
      
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labtests');
    }
}
