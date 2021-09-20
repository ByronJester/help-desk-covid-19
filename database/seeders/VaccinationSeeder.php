<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Place;
use App\Models\Vaccine;
use App\Models\Vaccination;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VaccinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $places = Place::get();

      $vaccines = Vaccine::get();

      $classification = [
      	'A1', 'A2', 'A3', 'A4', 'A5', 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'C'
      ];

	    foreach ($places as $key => $place) {

	    	foreach ($vaccines as $vaccine) {

	    		for ($i = 0; $i < rand(3, 40); $i++) { 
		     		Vaccination::create([
		     			'place_id' 			 => $place->id,
		     			'vaccine_id'		 => $vaccine->id,
		     			'name'			 		 => Str::random(10),
		     			'phone'					 => '09771023141',
		     			'age'	  		 		 => rand(1, 90),
		     			'birth_date'		 => Carbon::now()->subDays(rand(1, 730))->format('Y-m-d'),
		     			'gender'   			 => 'MALE',
		     			'classification' => $classification[array_rand($classification, 1)]
		     		]);
		     	}

	    	}

	    	foreach ($vaccines as $vaccine) {

	    		for ($i = 0; $i < rand(3, 40); $i++) { 
		     		Vaccination::create([
		     			'place_id' 			 => $place->id,
		     			'vaccine_id'		 => $vaccine->id,
		     			'phone'					 => '09771023141',
		     			'name'			 		 => Str::random(10),
		     			'age'	  		 		 => rand(1, 90),
		     			'birth_date'		 => Carbon::now()->subDays(rand(1, 730))->format('Y-m-d'),
		     			'gender'   			 => 'FEMALE',
		     			'classification' => $classification[array_rand($classification, 1)]
		     		]);
		     	}

	    	}
	    }
    }
}
