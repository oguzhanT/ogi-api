<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string $url
 */
class Application extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = ['id'];
}
