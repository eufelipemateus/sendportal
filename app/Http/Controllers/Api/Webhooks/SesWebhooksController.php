<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Webhooks;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Events\Webhooks\SesWebhookReceived;
use App\Http\Controllers\Controller;

class SesWebhooksController extends Controller
{
    /**
     * @throws Exception
     */
    public function handle(): Response
    {
        $payload = json_decode(request()->getContent(), true);

        Log::info('SES webhook received', ['payload' => $payload]);

        $payloadType = $payload['Type'] ?? null;

        if (! in_array($payloadType, ['SubscriptionConfirmation', 'Notification'], true)) {
            return response('OK (not processed).');
        }

        event(new SesWebhookReceived($payload, $payloadType));

        return response('OK');
    }
}
