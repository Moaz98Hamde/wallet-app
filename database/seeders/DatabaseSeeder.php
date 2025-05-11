<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WebhookPayload;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a user with a primary wallet
        $user = User::factory()->withPrimaryWallet()->create();

        // Create a transaction for a specific wallet
        $transaction = Transaction::factory()
            ->for($user->primaryWallet())
            ->create();

        // Create a webhook payload
        $webhook = WebhookPayload::factory()->create();

        // Create multiple wallets for a user
        $user = User::factory()
            ->has(Wallet::factory()->count(3))
            ->create();
    }
}
