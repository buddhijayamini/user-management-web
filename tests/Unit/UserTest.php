<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

      /** @test */
      function it_has_an_user()
      {
          $users = User::factory()->create();
          $this->assertInstanceOf('App\Models\User', $users);
      }
}
