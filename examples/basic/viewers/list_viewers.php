<?php

$loader = require dirname(__DIR__).'/../bootstrap.php';
$config = require dirname(__DIR__).'/../config.php';


use Planviewer\MapsApi;

$mapsapi = new MapsApi([
    'auth' => [$config['api-key'], $config['api-secret']],
    'base_uri' => (isset($config['base_uri']) ? $config['base_uri'] : 'https://www.planviewer.nl'),
    'verify' => false,
]);

$limit = 10;
$offset = 0;
$viewers = [];
do {

    $batch = $mapsapi->listViewers( ['limit'=>$limit, 'offset'=>$offset]);
    $viewers = array_merge($viewers, $batch->viewers);
    $offset += $limit;

} while(count($batch->viewers));

var_dump($viewers);
