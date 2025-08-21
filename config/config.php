<?php

return [
    'db' => [
        'host' => '127.0.0.1',
        'name' => 'miniapp',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
    'mail' => [
        'admin' => 'admin@example.com',
        'host' => 'smtp.example.com',
        'user' => 'smtp_user',
        'pass' => 'smtp_pass',
        'port' => 587,
        'secure'=> 'tls'
    ],
    'app' => [
        'base_url' => '/mini-app',
        'debug' => true
    ]
];