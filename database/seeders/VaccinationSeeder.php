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

	    foreach ($places as $key => $place) {

	    	foreach ($vaccines as $vaccine) {

	    		for ($i = 0; $i < rand(3, 25); $i++) { 
		     		Vaccination::create([
		     			'place_id' 			 => $place->id,
		     			'vaccine_id'		 => $vaccine->id,
		     			'name'			 		 => Str::random(10),
		     			'age'	  		 		 => rand(1, 90),
		     			'birth_date'		 => Carbon::now()->subDays(rand(1, 730))->format('Y-m-d'),
		     			'gender'   			 => 'MALE',
		     			'start_date'		 => Carbon::now()->subDays(rand(1, 100))->format('Y-m-d'),
		     			'completed_date' => Carbon::now()->subDays(rand(101, 200))->format('Y-m-d')
		     		]);

		     		Vaccination::create([
		     			'place_id' 			 => $place->id,
		     			'vaccine_id'		 => $vaccine->id,
		     			'name'			 		 => Str::random(10),
		     			'age'	  		 		 => rand(1, 90),
		     			'birth_date'		 => Carbon::now()->subDays(rand(1, 730))->format('Y-m-d'),
		     			'gender'   			 => 'FEMALE',
		     			'start_date'		 => Carbon::now()->subDays(rand(1, 100))->format('Y-m-d'),
		     			'completed_date' => Carbon::now()->subDays(rand(101, 200))->format('Y-m-d')
		     		]);
		     	}

	    	}
	     	
	     	
	    }
    }
}
