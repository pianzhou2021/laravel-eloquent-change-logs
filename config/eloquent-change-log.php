<?php

return [
    'max_value_length' => 255,
    'change_log_class' => \Pianzhou\EloquentChangeLog\Models\ChangeLog::class,
    'change_log_repository' => \Pianzhou\EloquentChangeLog\Repositories\ChangeLog::class,
    'migration' => [
        'change_logs' => [
            'model'         => [ 'string', [ 'length' => 255 ] ],
            'type'          => [ 'string', [ 'length' => 50 ] ],
            'key'           => [ 'string', [ 'length' => 50 ] ],
            'description'   => [ 'text' ],
            'old'           => [ 'text' ],
            'data'          => [ 'text' ],
        ],
    ],
    'record_hook' => function ($model) {
    },
    'watchers' => [
    ],
];
