<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $accountIdFrom = $request->input('from');
        $accountIdTo = $request->input('to');
        $amount = $request->input('amount');

        $transactionService = (new TransactionService($accountIdFrom, $accountIdTo, $amount));
        $response = $transactionService->validateTransaction();

        return response()->json($response);
    }
}
