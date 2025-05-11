<?php

use App\Enums\TransactionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('wallet_id');
            $table->foreign('wallet_id')->references('id')->on('wallets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('type')->default(TransactionType::CREDIT->value);
            $table->decimal('amount', 15, 2);
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->unique(['wallet_id', 'reference']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
