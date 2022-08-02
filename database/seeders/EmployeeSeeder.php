<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee =  [
            [
              'user_id' => 1,
              'company_id' => 1,
              'first_name' => 'Admin',
              'last_name' => 'Admin',
              'user_role' => 'Admin',
              'email' => 'admin@wearedesigners.net',
              'status' =>  1
            ],
            [
                'user_id' => 2,
                'company_id' => 1,
                'first_name' => 'Nimal',
                'last_name' => 'Perera',
                'user_role' => 'Media Manager',
                'email' => 'nimal@wearedesigners.net',
                'status' =>  1
              ]
        ];

        Employee::insert($employee);
    }
}
