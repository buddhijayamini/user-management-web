<?php

namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_has_a_company()
    {
       $company=Company::factory()->create();
       $this->assertInstanceOf('App\Models\Company', $company);
    }
}
