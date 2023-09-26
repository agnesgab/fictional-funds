<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserData()
    {
        $user = User::with('accounts.currency')->where('id', $this->userId)->get();

        $user->map(function ($item) {
            $item->accounts->map(function ($account) {
                $account->transactions_total_count = $account->transactionsTotalCount;
                $account->datetime = $account->formattedCreatedAt;

                return $account;
            });

            return $item;
        });

        return $user;
    }
}
