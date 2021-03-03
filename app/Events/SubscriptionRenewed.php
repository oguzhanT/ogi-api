<?php

namespace App\Events;

use App\Subscription;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionRenewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Subscription
     */
    public $subscription;

    /**
     * @var string
     */
    public $eventAction = 'renewed';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
