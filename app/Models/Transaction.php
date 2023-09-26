<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_account_id',
        'receiver_account_id',
        'amount_in_sender_currency',
        'amount_in_receiver_currency',
        'amount_in_base_currency',
    ];

    public function sender()
    {
        return $this->hasOne(Account::class, 'id', 'sender_account_id');
    }

    public function receiver()
    {
        return $this->hasOne(Account::class, 'id', 'receiver_account_id');
    }

    public function getFormattedTransactionDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }
}
