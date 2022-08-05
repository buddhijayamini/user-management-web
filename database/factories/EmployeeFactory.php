<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => 'Sarath',
            'last_name' => 'Perera',
            'status' => 1,
            'user_id' => 1,
            'company_id' => 1,
            'user_role'  => ''
        ];
    }
}
