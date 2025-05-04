<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Webhooks;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Events\Webhooks\PostalWebhookReceived;
use App\Http\Controllers\Controller;

class PostalWebhooksController extends Controller
{
    public function handle(): Response
    {
        $payload = json_decode(request()->getContent(), true);

        Log::info('Postal webhook received');

        event(new PostalWebhookReceived($payload));


        return response('OK');
    }
}
