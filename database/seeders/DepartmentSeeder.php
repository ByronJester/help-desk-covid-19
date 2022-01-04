<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'MDRRMO',
            'contact' => '69557347496',
            'email'		=> 'kingjohnlloydd@gmail.com'
        ]);

        Department::create([
            'name' => 'PNP',
            'contact' => '69557347496',
            'email'		=> 'kingjohnlloydd@gmail.com'
        ]);

    }
}
