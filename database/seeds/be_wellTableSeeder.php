<?php

use Illuminate\Database\Seeder;

class be_wellTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('be_wells')->insert([
            'patientName' => Str::random(16),
            'apptDate' => '2019-03-18',
             'doctorName' => Str::random(24),
             'doctorSpecialty' => Str::random(24),
             'fee' => '50.00',
             'reason' => Str::random(80),
             'diagnosis' => Str::random(512),
             'vitalsWeight' => '165',
             'vitalsBP' => Str::random(5),
        ]);
    }
}
