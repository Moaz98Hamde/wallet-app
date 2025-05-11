<?php

namespace App\Services\Webhooks\Handlers;


class AcmiBankHandler extends WebhookHandler
{
   public function handle($payload){

    }

    public function getWebhookType(): string
    {
        return 'acmi';
    }
}
