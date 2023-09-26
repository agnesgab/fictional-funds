<?php

use App\Http\Resources\UsersResource;
use App\Models\Account;
use App\Models\Currency;
use App\Models\User;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{any?}', function () {
    return view('app');
});
