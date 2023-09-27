<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountsResource;
use App\Http\Resources\TransactionsResource;
use App\Http\Resources\UsersResource;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::count();
        $accounts = Account::count();
        $transactions = Transaction::count();

        return response()->json([
            'users' => $users,
            'accounts' => $accounts,
            'transactions' => $transactions,
        ]);
    }
}
