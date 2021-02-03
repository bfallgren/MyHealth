<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentsToFamhistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('famhists', function (Blueprint $table) {
            $table->integer('comments')->after('symptoms');
        });

        DB::statement('ALTER TABLE famhists MODIFY COLUMN comments VARCHAR(256)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('famhists', function (Blueprint $table) {
            $table->dropColumn('comments');
        });
    }
}
