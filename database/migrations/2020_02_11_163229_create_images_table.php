<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('patientName');
            $table->date('apptDate');
            $table->string('doctorName');
            $table->string('doctorSpecialty');
            $table->integer('fee')->nullable();
            $table->string('reason')->nullable();
            $table->string('diagnosis')->nullable();
            $table->integer('vitalsWeight')->nullable();
            $table->string('vitalsBP')->nullable();
            $table->timestamps();
        });
         Schema::table('images', function ($table) {
            DB::statement('ALTER TABLE images MODIFY COLUMN patientName VARCHAR(32)');
            DB::statement('ALTER TABLE images MODIFY COLUMN doctorName VARCHAR(32)');
            DB::statement('ALTER TABLE images MODIFY COLUMN doctorSpecialty VARCHAR(24)');
            DB::statement('ALTER TABLE images MODIFY COLUMN reason VARCHAR(80)');
            DB::statement('ALTER TABLE images MODIFY COLUMN diagnosis VARCHAR(512)');
            DB::statement('ALTER TABLE images MODIFY COLUMN vitalsBP VARCHAR(16)');
      
        }); 

         Schema::table('images', function ($table) {
            DB::statement('ALTER TABLE images MODIFY COLUMN patientName VARCHAR(32)');
            DB::statement('ALTER TABLE images MODIFY COLUMN doctorName VARCHAR(32)');
            DB::statement('ALTER TABLE images MODIFY COLUMN doctorSpecialty VARCHAR(24)');
            DB::statement('ALTER TABLE images MODIFY COLUMN reason VARCHAR(80)');
            DB::statement('ALTER TABLE images MODIFY COLUMN diagnosis VARCHAR(512)');
            DB::statement('ALTER TABLE images MODIFY COLUMN vitalsBP VARCHAR(16)');
      
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
