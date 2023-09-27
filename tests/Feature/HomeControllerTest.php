<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function test_home_page_returning_successful_response()
    {
        $response = $this->get('api/');

        $response->assertStatus(200);
    }

    public function test_home_page_returning_data_for_3_models()
    {
        $response = $this->get('api/');

        $response->assertJsonCount(3);
    }

    public function test_home_page_returning_users_count()
    {
        $response = $this->get('api/');

        $usersCount = User::count();

        $response->assertJson(['users' => $usersCount]);
    }

    public function test_home_page_returning_accounts_count()
    {
        $response = $this->get('api/');

        $accountsCount = Account::count();

        $response->assertJson(['accounts' => $accountsCount]);
    }

    public function test_home_page_returning_transactions_count()
    {
        $response = $this->get('api/');

        $transactionsCount = Transaction::count();

        $response->assertJson(['transactions' => $transactionsCount]);
    }
}
