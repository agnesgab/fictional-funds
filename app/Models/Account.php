<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'currency_id',
        'account_balance',
        'title',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function sentTransactions()
    {
        return $this->hasMany(Transaction::class, 'sender_account_id', 'id');
    }

    public function receivedTransactions()
    {
        return $this->hasMany(Transaction::class, 'receiver_account_id', 'id');
    }

    public function getAllTransactionsAttribute()
    {
        $allTransactions = $this->sentTransactions->concat($this->receivedTransactions);

        $allTransactions->map(function ($transaction) {
            $transaction->datetime = $transaction->created_at->format('d-m-Y H:i:s');
            return $transaction;
        });

        return $allTransactions->sortByDesc('created_at');
    }

    public function getTransactionsTotalCountAttribute()
    {
        return $this->getAllTransactionsAttribute()->count();
    }

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y H:i:s');
    }
}
