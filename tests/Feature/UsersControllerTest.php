<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    public function test_returning_successful_response()
    {
        $user = \Mockery::mock(User::class);
        $user->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $response = $this->get("/api/user/{$user->id}");

        $response->assertStatus(200);
    }
}
