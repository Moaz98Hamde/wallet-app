<?php

namespace App\Services\Webhooks\Handlers;


class FoodicsBankHandler extends WebhookHandler
{
    public function handle($payload)
    {
        $data = $this->parse($payload);
        $amount = $data['amount'] ?? 0;
        $reference = $data['reference'] ?? null;
        $wallet = auth()->user()->wallet;

        if ($wallet->transactions()->where('reference', $reference)->exists()) {
            return;
        }

    }

        public function parse(string $webhookData)
    {
        // Split the input into lines
        $lines = array_filter(explode("\n", $webhookData));

        $result = [];

        // Process the first line
        if (isset($lines[0])) {
            // Pattern for the first line
            // Matches: date,amount#reference#key/value
            $pattern = '/^(\d+),(\d+\.?\d*)#(\w+)#(.+)$/';

            if (preg_match($pattern, $lines[0], $matches)) {
                $result = [
                    'date' => $matches[1],
                    'amount' => (float) $matches[2],
                    'reference' => $matches[3],
                    'initial_key_value' => $this->parseKeyValue($matches[4])
                ];
            }
        }

        // Process additional key-value lines
        if (isset($lines[1])) {
            $result['additional_data'] = $this->parseKeyValue($lines[1]);
        }

        return $result;
    }

    private function parseKeyValue(string $keyValueString)
    {
        $parts = explode('/', $keyValueString);
        $result = [];

        // Handle multi-level key-value pairs
        for ($i = 0; $i < count($parts) - 1; $i++) {
            if (isset($parts[$i + 1])) {
                $result[$parts[$i]] = $parts[$i + 1];
            }
        }

        return $result;
    }

    public function getWebhookType(): string
    {
        return 'foodics';
    }
}
