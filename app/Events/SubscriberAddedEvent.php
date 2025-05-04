<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Subscriber;

class SubscriberAddedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /** @var Subscriber */
    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }
}
