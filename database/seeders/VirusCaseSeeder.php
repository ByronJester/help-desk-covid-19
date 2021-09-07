<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Place;
use App\Models\VirusCase;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VirusCaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $places = Place::get();

    foreach ($places as $key => $place) {
     	
     	for ($i = 0; $i < rand(3, 25); $i++) { 
     		VirusCase::create([
     			'place_id'   => $place->id,
     			'code'		 => Str::random(10),
     			'age'	     => rand(1, 90),
     			'gender'	 => 'MALE',
     			'date'		 => Carbon::now()->subDays(rand(1, 730))->format('Y-m-d'),
     			'status'     => 'RECOVERED'
     		]);
     	}

     	for ($i = 0; $i < rand(3, 25); $i++) { 
     		VirusCase::create([
     			'place_id'   => $place->id,
     			'code'		 => Str::random(10),
     			'age'	     => rand(1, 90),
     			'gender'	 => 'FEMALE',
     			'date'		 => Carbon::now()->subDays(rand(1, 730))->format('Y-m-d'),
     			'status'     => 'DEATH'
     		]);
     	}

     	for ($i = 0; $i < rand(3, 25); $i++) { 
     		VirusCase::create([
     			'place_id'   => $place->id,
     			'code'		 => Str::random(10),
     			'age'		 => rand(1, 90),
     			'gender'	 => 'MALE',
     			'date'		 => Carbon::now()->subDays(rand(1, 730))->format('Y-m-d'),
     			'status'     => 'QUARANTINE'
     		]);
     	}
    }
  }
}
