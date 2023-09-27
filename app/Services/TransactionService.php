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

    public function applyExchangeRates($fromExchangeRate, $toExchangeRate, $amount)
    {
        if ($this->accountBalanceIsPositive($this->accountFrom->balance, $this->amount)) {
            $this->amountWithBaseRate = $amount / $fromExchangeRate;
            $this->amountToTransfer = $this->amountWithBaseRate * $toExchangeRate;

            return round($this->amountToTransfer, 2);
        }

        return false;
    }

    public function getTransactionData($idFrom, $idTo)
    {
        $this->accountFrom = Account::with('currency')->find($idFrom);
        $this->accountTo = Account::with('currency')->find($idTo);

        if ($this->accountFrom && $this->accountTo) {
            return $this->applyExchangeRates(
                $this->accountFrom->currency->exchange_rate,
                $this->accountTo->currency->exchange_rate,
                $this->amount
            );
        }

        return false;
    }

    public function accountBalanceIsPositive($accountBalance, $amount)
    {
        return $accountBalance - $amount >= 0;
    }

    public function validateTransaction()
    {
        if ($this->getTransactionData($this->accountIdFrom, $this->accountIdTo)) {
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
