<?php

declare(strict_types=1);

return [
    'db' => [
        'host' => getenv('DB_HOST') ?: 'db',
        'dbname' => getenv('DB_NAME') ?: 'lucky_db',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: 'root_password',
        'charset' => 'utf8mb4'
    ]
];
