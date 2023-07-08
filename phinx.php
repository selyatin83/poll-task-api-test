<?php
$dotEnv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotEnv->load();

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/kernel/console/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/kernel/console/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'production',
        'production' => [
            'adapter' => 'pgsql',
            'host' => env('DB_HOST'),
            'name' => env('DB_NAME'),
            'user' => env('DB_USER'),
            'pass' => env('DB_PASSWORD'),
            'port' => env('DB_PORT'),
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'pgsql',
            'host' => env('DB_HOST'),
            'name' => env('DB_NAME'),
            'user' => env('DB_USER'),
            'pass' => env('DB_PASSWORD'),
            'port' => env('DB_PORT'),
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'pgsql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
