<?php

declare(strict_types=1);

$paths = [
     // local dev repository
     __DIR__ . '/../vendor/autoload.php',
     // dependency
     __DIR__ . '/../../../autoload.php',
];

foreach ($paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        break;
    }
}

    $configFile = require __DIR__ . '../../config/config.php';
    $config = [
        'auth' => [$configFile['api-key'], $configFile['api-secret']],
    ];

