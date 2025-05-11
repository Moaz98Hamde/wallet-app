<?php

namespace App\Enums;

enum WebhookPayloadStatus: int
{
    case PENDING =1;
    case PROCESSED = 2;
    case FAILED = 3;

    public function toString(): string
    {
        return match ($this) {
            self::PENDING => 'pending',
            self::PROCESSED => 'processed',
            self::FAILED => 'failed'
        };
    }
}
