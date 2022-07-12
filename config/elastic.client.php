<?php declare(strict_types=1);

return [
    'hosts' => [
        env('ELASTIC_HOST', 'localhost:9200'),
    ],

    'connectionParams' => [
        'client' => [
            'timeout' => env('ELASTIC_TIMEOUT'),
            'connect_timeout' => env('ELASTIC_CONNECT_TIMEOUT'),
        ],
    ],
];
