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
            $table->string('patientName');
            $table->date('testDate');
            $table->string('component');
            $table->float('measuredValue',6,2);
            $table->string('goodRange')->nullable();
            $table->string('comments')->nullable();
            $table->timestamps();
        });

     Schema::table('labs', function ($table) {
        DB::statement('ALTER TABLE labs MODIFY COLUMN patientName VARCHAR(32)');
        DB::statement('ALTER TABLE labs MODIFY COLUMN component VARCHAR(24)');
        DB::statement('ALTER TABLE labs MODIFY COLUMN goodRange VARCHAR(24)');
        DB::statement('ALTER TABLE labs MODIFY COLUMN comments VARCHAR(512)');
         DB::statement('ALTER TABLE labs MODIFY COLUMN measuredValue FLOAT(6,2)');
      
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
