<?php

namespace Pianzhou\EloquentChangeLog\Models;

use Illuminate\Database\Eloquent\Model;
use Pianzhou\EloquentChangeLog\Enums\ChangeLog\Type;

class ChangeLog extends Model
{
    protected $fillable = [
        'key',
        'type',
        'model',
        'description',
        'old',
        'data',
    ];

    protected $casts    = [
        'type'  => Type::class,
        'old'   => 'json',
        'data'  => 'json',
    ];
}
