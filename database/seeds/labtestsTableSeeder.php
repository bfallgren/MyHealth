<?php

use Illuminate\Database\Seeder;

class labtestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('labtests')->insert([
            'patientName' => Str::random(16),
            'testDate' => '2019-03-18',
             'component' => Str::random(24),
             'measuredvalue' => '99999',
             'goodRange' => Str::random(24),
             'comments' => Str::random(512),
             
        ]);
    }
}
