<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurgerysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surgeries', function (Blueprint $table) {
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

        Schema::table('surgeries', function ($table) {
            DB::statement('ALTER TABLE surgeries MODIFY COLUMN patientName VARCHAR(32)');
            DB::statement('ALTER TABLE surgeries MODIFY COLUMN doctorName VARCHAR(32)');
            DB::statement('ALTER TABLE surgeries MODIFY COLUMN doctorSpecialty VARCHAR(24)');
            DB::statement('ALTER TABLE surgeries MODIFY COLUMN reason VARCHAR(80)');
            DB::statement('ALTER TABLE surgeries MODIFY COLUMN diagnosis VARCHAR(512)');
            DB::statement('ALTER TABLE surgeries MODIFY COLUMN vitalsBP VARCHAR(16)');
      
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surgeries');
    }
}
