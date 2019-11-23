<?php

use Illuminate\Database\Seeder;

class surgeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('surgeries')->insert([
            'patientName' => Str::random(10),
            'apptDate' => '2019-03-18',
             'doctorName' => Str::random(10),
             'doctorSpecialty' => Str::random(10),
             'fee' => '50.00',
             'reason' => Str::random(10),
             'diagnosis' => Str::random(10),
             'vitalsWeight' => '165',
             'vitalsBP' => Str::random(5),
        ]);
    }
}
