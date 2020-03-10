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
            $table->string('patient');
            $table->string('familyMember');
            $table->string('relation');
            $table->integer('symptoms');
            $table->timestamps();
        });

     Schema::table('famhists', function ($table) {
            DB::statement('ALTER TABLE famhists MODIFY COLUMN patient VARCHAR(16)');
            DB::statement('ALTER TABLE famhists MODIFY COLUMN familyMember VARCHAR(16)');
            DB::statement('ALTER TABLE famhists MODIFY COLUMN relation VARCHAR(16)');
            DB::statement('ALTER TABLE famhists MODIFY COLUMN symptoms VARCHAR(80)');
                        
      
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
