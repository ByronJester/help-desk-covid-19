<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\Place;
use App\Models\Vaccine;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Vaccine::create([
      	'name' => 'SINOVAC',
      	'dosage' => 2
      ]);

      Vaccine::create([
      	'name' => 'MODERNA',
      	'dosage' => 2
      ]);

      Vaccine::create([
      	'name' => 'PFIZER',
      	'dosage' => 2
      ]);

      Vaccine::create([
        'name' => 'JOHNSON AND JOHNSON',
        'dosage' => 1
      ]);

      Vaccine::create([
        'name' => 'ASTRAZENECA',
        'dosage' => 1
      ]);
    }
}
