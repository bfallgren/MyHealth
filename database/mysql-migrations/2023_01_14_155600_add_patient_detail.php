<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPatientDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('fullname',48)->after('name')->nullable();
            $table->date('birthdate')->nullable()->after('fullname');
            $table->string('insurance',48)->after('birthdate')->nullable();
            $table->string('memberID',24)->after('insurance')->nullable();
        });
        /*
        DB::statement('ALTER TABLE patients MODIFY COLUMN fullname VARCHAR(48)');
        DB::statement('ALTER TABLE patients MODIFY COLUMN insurance VARCHAR(48)');
        DB::statement('ALTER TABLE patients MODIFY COLUMN memberID VARCHAR(24)'); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('fullname');
        $table->dropColumn('birthdate');
        $table->dropColumn('insurance');
        $table->dropColumn('memberID');
    }
}
