<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =  [
            [
              'name' => 'admin',
              'email' => 'admin@wearedesigners.net',
              'password'=> Hash::make('654321'),
              'type' => 1
            ],
            [
                'name' => 'nimal',
                'email' => 'nimal@wearedesigners.net',
                'password'=> Hash::make('123456'),
                'type' => 2
              ]
        ];

        User::insert($user);
    }
}
