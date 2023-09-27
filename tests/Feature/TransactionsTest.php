<?php

use App\Models\Account;
use App\Services\TransactionService;
use Tests\TestCase;

class TransactionsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->accountFrom = Mockery::mock(Account::class);
        $this->accountFrom->shouldReceive('getAttribute')->with('balance')->andReturn(100);
        $this->balance = $this->accountFrom->getAttribute('balance');
    }

    public function test_account_balance_returned_positive()
    {
        $transactionService = new TransactionService(1, 2, 99);

        $result = $transactionService->accountBalanceIsPositive($this->balance, 99);
        $this->assertEquals(true, $result);
    }

    public function test_account_balance_returned_negative()
    {
        $transactionService = new TransactionService(1, 2, 101);

        $result = $transactionService->accountBalanceIsPositive($this->balance, 101);
        $this->assertEquals(false, $result);
    }

    public function test_exchange_rates_applied_correctly()
    {
        $transactionService = Mockery::mock(TransactionService::class);
        $transactionService->shouldReceive('applyExchangeRates')->once()->andReturn(true);

        $result = $transactionService->applyExchangeRates(1, 1.5, 100);

        $this->assertEquals(150, $result);
    }

    public function test_cannot_apply_exchange_rates_if_account_balance_negative()
    {
        $transactionService = Mockery::mock(TransactionService::class);
        $transactionService->shouldReceive('applyExchangeRates')->once()->andReturn(false);

        $result = $transactionService->applyExchangeRates(1, 1.5, 100);

        $this->assertEquals(false, $result);
    }

    public function test_tax_rates_not_applied_if_account_from_non_existent()
    {
        $transactionService = new TransactionService(99999, 1, 100);

        $result = $transactionService->getTransactionData(99999, 1);

        $this->assertFalse($result);
    }

    public function test_tax_rates_not_applied_if_account_to_non_existent()
    {
        $transactionService = new TransactionService(1, 99999, 100);

        $result = $transactionService->getTransactionData(1, 99999);

        $this->assertFalse($result);
    }
}
