<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VirusCase;
use App\Models\ContactTracing;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ContactTracingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cases = VirusCase::get();

        $gender = [
	      	'MALE', 'FEMALE'
	      ];

	      $status = [
	      	'active', 'inactive'
	      ];

        foreach ($cases as $case) {

        	ContactTracing::create([
        		'place_id' => $case->place_id,
        		'virus_case_id' => $case->id,
        		'name' => Str::random(10),
        		'age' => rand(1, 90),
        		'birth_date' => Carbon::now()->subDays(rand(1, 730))->format('Y-m-d'),
        		'phone' => '09771023141',
        		'gender' => $gender[array_rand($gender, 1)],
        		'status' => $status[array_rand($status, 1)]
        	]);

        }
    }
}
