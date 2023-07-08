<?php

return [
    'db' => [
        'driver' => 'pgsql',
        'host' => env('DB_HOST'),
        'username' => env('DB_USER'),
        'password' => env('DB_PASSWORD'),
        'database' => env('DB_NAME'),
        'charset' => 'utf8',
    ]
];