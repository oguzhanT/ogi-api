<?php

namespace App;

use App\Events\SubscriptionCanceled;
use App\Events\SubscriptionRenewed;
use App\Events\SubscriptionStarted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Event;

/**
 * @property int $id
 * @property int $device_id
 * @property string|\DateTime $expire_date
 * @property bool $status
 */
class Subscription extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'expire_date'];
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($subscription) {
            SubscriptionStarted::dispatch($subscription);
        });

        static::updated(function ($subscription) {
            $changes = $subscription->getChanges();
            if (isset($changes['expire_date'])) {
                SubscriptionRenewed::dispatch($subscription);
            }
            if (isset($changes['status']) && $changes['status'] === false) {
                SubscriptionCanceled::dispatch($subscription);
            }
        });

        static::deleted(function ($subscription) {
            SubscriptionCanceled::dispatch($subscription);
        });
    }

    public function device(): HasOne
    {
        return $this->hasOne(Device::class, 'id', 'device_id');
    }
}
