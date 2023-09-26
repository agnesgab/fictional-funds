<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountsResource;
use App\Models\Account;
use App\Services\AccountService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = (new AccountService($id));
        $account = $service->getAccountData();

        return AccountsResource::collection($account);
    }
}
