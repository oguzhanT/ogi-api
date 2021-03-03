<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $uid
 * @property int $os_id
 * @property int $app_id
 * @property int $language_id
 * @property string $token
 */
class Device extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'uid',
        'app_id',
        'os_id',
        'language_id',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'token',
    ];

    public function application(): HasOne
    {
        return $this->hasOne(Application::class, 'id', 'app_id');
    }

    public function language(): HasOne
    {
        return $this->hasOne(Language::class, 'id', 'app_id');
    }

    public function operatingSystem(): HasOne
    {
        return $this->hasOne(OperatingSystem::class, 'id', 'app_id');
    }

    public function Subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'devide_id', 'id');
    }
}
