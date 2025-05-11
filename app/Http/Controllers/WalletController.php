<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletRequest;
use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected WalletService $walletService;

    public function index(Request $request)
    {
        $wallet = $this->walletService->getWallets($request->user());
        return response()->json($wallet->load('transactions'));
    }

    public function credit(WalletRequest $request)
    {
        $wallet = $this->walletService->getWallets($request->user());
        $transaction = $this->walletService->credit($wallet, $request->amount, $request->description);

        return response()->json($transaction, 201);
    }

    public function debit(WalletRequest $request)
    {
        $wallet = $this->walletService->getWallets($request->user());

        try {
            $transaction = $this->walletService->debit($wallet, $request->amount, $request->description);
            return response()->json($transaction, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}

