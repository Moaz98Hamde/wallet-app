<?php

namespace App\Models;

use App\Enums\WebhookPayloadStatus;
use Illuminate\Database\Eloquent\Model;

class WebhookPayload extends Model
{
    protected $fillable = ['bank_name', 'payload','status'];

    protected function casts(): array
    {
        return [
            'status' => WebhookPayloadStatus::class,
        ];
    }

    public function getPayloadAttribute($value)
    {
        //  Normalize the payload to a consistent format
    }
}
