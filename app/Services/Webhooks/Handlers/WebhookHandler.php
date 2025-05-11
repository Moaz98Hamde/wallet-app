<?php

namespace App\Services\Webhooks\Handlers;


abstract class WebhookHandler
{
    abstract public function handle($payload);
}
