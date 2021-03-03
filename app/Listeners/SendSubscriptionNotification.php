<?php

namespace App\Listeners;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psr\Http\Client\ClientExceptionInterface;

class SendSubscriptionNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $device = $event->subscription->device;
        $url = $device->application->url;

        try {
            $response = Http::retry(5, 100)->post($url, [
                'deviceId' => $device->uid,
                'appId' => $device->application->key,
                'event' => $event->eventAction
            ]);
        } catch (ConnectionException $exception) {
            Log::error('Device: '.$device->id.' - '. $event->eventAction.' - '.$exception->getMessage());
        }
    }
}
