<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_has_an_employee()
    {
      $user=User::factory()->create();
      $company=Company::factory()->create();
      $employees=Employee::factory([
          'first_name' => 'Kamal',
          'last_name' => 'Perera',
          'status' => 1,
          'user_id' =>  $user->id,
          'company_id' =>  $company->id,
          'user_role'  => ''
      ])->create();

        $this->assertInstanceOf('App\Models\Employee', $employees);
    }
}
