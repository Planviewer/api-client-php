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

use Planviewer\MapsApi;

$config = require __DIR__ . '/config.php';

$mapsapi = new MapsApi([
    'auth' => [$config['api-key'], $config['api-secret']],
    'base_uri' => (isset($config['base_uri']) ? $config['base_uri'] : 'https://www.planviewer.nl'),
    'verify' => false,
]);

return $mapsapi;
