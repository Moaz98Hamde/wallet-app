<?php

namespace App\Services\Webhooks;

use App\Jobs\ProcessWebhookPayload;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    protected $payload;
    protected $bankName;

    public static function make(){
        Log::info('Webhook received: ' . request()->all());
        return new self();
    }

    public function setBankName(string $bankName): self
    {
        $this->bankName = $bankName;
        return $this;
    }

    public function setPayload(string $payload): self
    {
        $this->payload = $payload;
        return $this;
    }

    public function queue(): self
    {
        $handler = $this->getHandler();
        dispatch(new ProcessWebhookPayload($handler, $this->payload));
        return $this;
    }

    private function getHandler()
    {
        $handlerClass = 'App\\Services\\Webhooks\\Handlers\\' . ucfirst($this->bankName) . 'BankHandler';
        if (class_exists($handlerClass)) {
            return new $handlerClass();
        }

        throw new \Exception('Handler not found for bank: ' . $this->bankName);
    }

}
