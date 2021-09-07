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
      	'name' => 'sinovac',
      	'dosage' => 2
      ]);

      Vaccine::create([
      	'name' => 'moderna',
      	'dosage' => 2
      ]);

      Vaccine::create([
      	'name' => 'pfizer',
      	'dosage' => 2
      ]);
    }
}
