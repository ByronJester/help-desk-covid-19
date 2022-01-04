<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	UserSeeder::class,
            PlaceSeeder::class,
            DepartmentSeeder::class,
            // VirusCaseSeeder::class,
            // VaccineSeeder::class,
            // ContactTracingSeeder::class,
            // VaccinationSeeder::class
        ]);
    }
}
