<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;

class TransactionService
{
    private int $accountIdFrom;
    private int $accountIdTo;
    private float $amount;
    private $accountFrom;
    private $accountTo;
    private $amountToTransfer;
    private $amountWithBaseRate;

    public function __construct(int $accountIdFrom, int $accountIdTo, $amount)
    {
        $this->accountIdFrom = $accountIdFrom;
        $this->accountIdTo = $accountIdTo;
        $this->amount = $amount;
    }

    public function applyExchangeRates()
    {
        $this->amountWithBaseRate = $this->amount / $this->accountFrom->currency->exchange_rate;
        $this->amountToTransfer = $this->amountWithBaseRate * $this->accountTo->currency->exchange_rate;

        return round($this->amountToTransfer, 2);
    }

    public function getTransactionData()
    {
        $this->accountFrom = Account::with('currency')->find($this->accountIdFrom);
        $this->accountTo = Account::with('currency')->find($this->accountIdTo);

        if ($this->accountFrom && $this->accountTo) {
            return $this->accountBalanceIsPositive();
        }

        return false;
    }

    public function accountBalanceIsPositive()
    {
        return $this->accountFrom->balance - $this->amount >= 0 ? $this->applyExchangeRates() : false;
    }

    public function validateTransaction()
    {
        if ($this->getTransactionData()) {
            $this->storeTransaction();
            $this->updateAccountBalances();

            return true;
        }

        return false;
    }

    public function storeTransaction()
    {
        Transaction::create([
            'sender_account_id' => $this->accountFrom->id,
            'receiver_account_id' => $this->accountTo->id,
            'amount_in_sender_currency' => $this->amount,
            'amount_in_receiver_currency' => $this->amountToTransfer,
            'amount_in_base_currency' => $this->amountWithBaseRate,
        ]);
    }

    public function updateAccountBalances()
    {
        $updatedSenderBalance = $this->accountFrom->balance - $this->amount;
        Account::where('id', $this->accountFrom->id)->update([
            'balance' => $updatedSenderBalance,
        ]);

        $updatedReceiverBalance = $this->accountTo->balance + $this->amountToTransfer;
        Account::where('id', $this->accountTo->id)->update([
            'balance' => $updatedReceiverBalance,
        ]);
    }
}
