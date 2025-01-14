<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => 'password',
            'mobile' => '9090909000',
            'role' => 'admin',
        ]);

        $user = User::create([
            'name' => 'user',
            'username' => 'user',
            'password' => 'password',
            'mobile' => '9090909090',
        ]);




    }
}
