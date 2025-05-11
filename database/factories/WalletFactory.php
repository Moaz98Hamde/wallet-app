<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'balance' => fake()->randomFloat(2, 0, 10000),
            'is_primary' => false,
            'user_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the wallet is primary
     */
    public function primary(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_primary' => true,
        ]);
    }
}
