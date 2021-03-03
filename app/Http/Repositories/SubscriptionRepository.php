<?php

namespace App\Http\Repositories;

use App\Device;
use App\Providers\SubscriptionAction;
use App\Subscription;
use Carbon\Carbon;

class SubscriptionRepository
{
    public function create(Device $device, string $expireDate, bool $status): Subscription
    {
        $subscription = new Subscription();

        $subscription->device_id = $device->id;
        $subscription->expire_date = $expireDate;
        $subscription->status = $status;
        $subscription->save();

        return $subscription;
    }

    public function renew(Subscription $subscription, string $expireDate): Subscription
    {
        $subscription->expire_date = $expireDate;
        $subscription->save();

        return $subscription;
    }

    public function getActiveSubscription(Device $device): ?Subscription
    {
        $now = Carbon::now()->setTimezone('America/New_York')->format('Y-m-d H:i:s');

        return Subscription::where('device_id', $device->id)
            ->where('expire_date', '>', $now)
            ->first();
    }
}
