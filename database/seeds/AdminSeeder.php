<?php

use Illuminate\Database\Seeder;
use App\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'Admin',
        	'username' => 'admin',
        	'role' => 'admin',
        	'phone' => '254712345678',
        	'email' => 'admin@smartcare.co.ke',
        	'password' => Hash::make('admin2020'),
            'user' => 1
        ]);
    }
}
