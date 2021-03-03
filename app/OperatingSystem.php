<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 */
class OperatingSystem extends Model
{
    const IOS = 'ios';
    const ANDROID = 'android';
    const OTHER = 'other';

    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = ['id'];
}
