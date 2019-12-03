<?php

$loader = require dirname(__DIR__).'/../bootstrap.php';
$config = require dirname(__DIR__).'/../config.php';


use Planviewer\MapsApi;

$mapsapi = new MapsApi([
    'auth' => [$config['api-key'], $config['api-secret']],
    'base_uri' => (isset($config['base_uri']) ? $config['base_uri'] : 'https://www.planviewer.nl'),
]);

var_dump($mapsapi->listViewers());
