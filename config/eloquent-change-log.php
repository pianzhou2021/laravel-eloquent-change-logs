<?php

return [
    'max_value_length' => 255,
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
