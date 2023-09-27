<?php

use App\Http\Controllers\Api\AccountsController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\TransactionsController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index']);

// Users
Route::get('/user/{userId}', [UsersController::class, 'show']);

// Accounts
Route::get('/account/{accountId}', [AccountsController::class, 'show']);

// Transactions
Route::post('/complete-transaction', [TransactionsController::class, 'store']);
