<?php

/**
 * Copyright (c) 2019 Planviewer BV.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/Planviewer/api-client-php
 *
 *
 * Example listing viewers in an Application
 *
 * @see https://docs.planviewer.nl/mapsapi/server_calls/viewers.html#list-viewers
 */

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
