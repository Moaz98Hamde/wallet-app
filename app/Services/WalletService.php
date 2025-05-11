<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function getWallets(User $user, bool $primaryWallet = true)
    {
        if ($primaryWallet) {
            return $user->primaryWallet();
        }

        return $user->wallets;
    }

    public function credit(Wallet $wallet, float $amount, ?string $description)
    {
        return DB::transaction(function () use ($wallet, $amount, $description) {
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->firstOrFail();
            $wallet->balance += $amount;
            $wallet->save();

            return $wallet->transactions()->create([
                'type' => TransactionType::CREDIT,
                'amount' => $amount,
                'description' => $description,
            ]);
        });
    }

    public function debit(Wallet $wallet, float $amount, ?string $description)
    {
        if ($wallet->balance < $amount) {
            throw new \Exception("Insufficient balance.");
        }

        return DB::transaction(function () use ($wallet, $amount, $description) {
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->firstOrFail();
            $wallet->balance -= $amount;
            $wallet->save();

            return $wallet->transactions()->create([
                'type' => 'debit',
                'amount' => $amount,
                'description' => $description,
            ]);
        });
    }
}
