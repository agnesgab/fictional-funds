<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Services\AccountService;
use Tests\TestCase;

class AccountsTest extends TestCase
{
    public function test_account_data_retrieved()
    {
        $service = new AccountService(1);
        $result = $service->getAccountData();

        $this->assertInstanceOf(Account::class, $result[0]);
    }
}
