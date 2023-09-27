<?php

namespace Tests\Feature;

use App\Models\Account;
use Tests\TestCase;

class AccountsControllerTest extends TestCase
{
    public function test_returning_successful_response()
    {
        $account = \Mockery::mock(Account::class);
        $account->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $response = $this->get("/api/account/{$account->id}");

        $response->assertStatus(200);
    }

    public function test_get_data_array_in_response()
    {
        $account = \Mockery::mock(Account::class);
        $account->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $response = $this->get("/api/account/{$account->id}");

        $response->assertJsonIsArray('data');
    }
}
