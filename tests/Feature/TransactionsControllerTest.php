<?php

namespace Tests\Feature;

use App\Models\Account;
use Tests\TestCase;

class TransactionsControllerTest extends TestCase
{
    public function test_transaction_stored_successfully()
    {
        $accountFrom = \Mockery::mock(Account::class);
        $accountFrom->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $accountTo = \Mockery::mock(Account::class);
        $accountTo->shouldReceive('getAttribute')->with('id')->andReturn(2);
        $amount = 100;

        $data = [
            'from' => $accountFrom->id,
            'to' => $accountTo->id,
            'amount' => $amount,
        ];

        $response = $this->post('/api/complete-transaction', $data);

        $response->assertStatus(200);
    }
}
