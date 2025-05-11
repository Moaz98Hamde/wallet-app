<?php

namespace App\Http\Controllers;

use App\Services\Webhooks\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __invoke(Request $request, string $bank)
    {
        try {
            WebhookService::make()
                ->setBankName($bank)
                ->setPayload($request->getContent())
                ->queue();

        } catch (\Exception $e) {
            Log::alert('===============================================================');
            Log::alert('Webhook error: ' . $e->getMessage());
            Log::alert('Webhook payload: ' . $request->getContent());
            Log::alert('Webhook bank: ' . $bank);
            Log::alert('Webhook request: ' . json_encode($request->all()));
            Log::alert('===============================================================');
            return response()->json(['message' => 'Error processing webhook.'], 500);
        }

        return response()->json(['message' => 'Webhook received.'], 200);
    }
}
