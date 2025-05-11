<?php

namespace App\Jobs;

use App\Services\Webhooks\Handlers\WebhookHandler;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessWebhookPayload implements ShouldQueue
{
    use Queueable;
    private string $payload;
    private WebhookHandler $handler;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $payload = $this->payload;
        $lines = explode("\n", trim($payload));
        DB::beginTransaction();

        try {
            foreach ($lines as $line) {
                $this->handler->handle($line);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Webhook Processing Error: ' . $e->getMessage());
        }
    }
}
