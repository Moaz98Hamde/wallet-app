<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['balance'];

    protected static function booted()
    {
        static::creating(function ($wallet) {
            if (empty($wallet->id)) {
                $wallet->id = (string) Str::uuid();
            }
            if (auth()->user() && auth()->user()->wallets()->count() === 0) {
                $wallet->is_primary = true;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
