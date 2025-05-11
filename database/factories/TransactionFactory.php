<?php

namespace Database\Factories;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'description' => fake()->sentence(),
            'type' => fake()->randomElement(TransactionType::cases()),
            'wallet_id' => Wallet::factory(),
        ];
    }
}
