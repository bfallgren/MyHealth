<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDoctorDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('patientName',32)->after('name');
            $table->string('location',36)->nullable()->after('specialty');
            $table->string('hospital',36)->nullable()->after('location');
            $table->boolean('active')->nullable()->after('hospital');
            $table->integer('doctorRating')->nullable()->after('active');
            $table->integer('staffRating')->nullable()->after('doctorRating');
            $table->string('services',64)->nullable()->after('staffRating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('location');
        $table->dropColumn('hospital');
        $table->dropColumn('active');
        $table->dropColumn('doctorRating');
        $table->dropColumn('staffRating');
        $table->dropColumn('services');

    }
}
