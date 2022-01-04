<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'first_name' => 'LGU',
        	'last_name' => 'LGU',
        	'phone' =>  '09771023141',
        	'email' => 'admin.lgu@email.com',
        	'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        	'user_type'	=> 'admin',
            'agree' => 1,
        	'perspective' => 1,
            'is_active'   => 1,
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now(),
        ]);

        // User::create([
        // 	'first_name' => 'Hospital',
        // 	'last_name' => 'Hospital',
        // 	'phone' =>  '09354315556',
        // 	'email' => 'admin.hospital@email.com',
        // 	'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        // 	'user_type'	=> 'admin',
        // 	'perspective' => 2,
        //     'is_active'   => true,
        // 	'created_at' => Carbon::now(),
        // 	'updated_at' => Carbon::now(),
        // ]);

        // User::create([
        // 	'first_name' => 'Citizen',
        // 	'last_name' => 'Citizen',
        // 	'phone' =>  '09059264056',
        // 	'email' => 'citizen@email.com',
        // 	'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        // 	'user_type'	=> 'citizen',
        // 	'perspective' => 3,
        //     'is_active'   => true,
        // 	'created_at' => Carbon::now(),
        // 	'updated_at' => Carbon::now(),
        // ]);
    }
}
