<?php

namespace App\Services;

use App\Models\Account;

class AccountService
{
    private string $accountId;

    public function __construct(string $accountId)
    {
        $this->accountId = $accountId;
    }

    public function getAccountData()
    {
        $account = Account::with('currency', 'user', 'sentTransactions.receiver.currency', 'receivedTransactions.sender.currency')
            ->where('id', $this->accountId)
            ->get();

        $account->map(function ($item) {
            $item->all_transactions = $item->allTransactions;
            $item->total_transactions = $item->transactionsTotalCount;

            return $item;
        });

        return $account;
    }
}
