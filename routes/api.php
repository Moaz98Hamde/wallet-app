<?php

use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wallet', [WalletController::class, 'index']);
    Route::post('/wallet/credit', [WalletController::class, 'credit']);
    Route::post('/wallet/debit', [WalletController::class, 'debit']);
});
