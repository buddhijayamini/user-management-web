<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company =  [
            [
              'name' => 'ABC Company',
              'email' => 'abc@wearedesigners.net'
            ]
        ];

        Company::insert($company);
    }
}
