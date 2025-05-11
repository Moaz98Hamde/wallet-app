<?php

namespace App\Enums;

enum TransactionType: int
{
    case CREDIT = 1;
    case DEBIT = 2;

    public function toString(): string
    {
        return match ($this) {
            self::CREDIT => 'credit',
            self::DEBIT => 'debit'
        };
    }
}
