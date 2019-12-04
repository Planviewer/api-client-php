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
 * Example list layers in a viewer
 *
 * @see https://docs.planviewer.nl/mapsapi/server_calls/layers.html#list-the-layers-in-a-viewer
 */

$loader = require dirname(__DIR__).'/../bootstrap.php';
$config = require dirname(__DIR__).'/../config.php';

/** target viewer for these examples */
$viewer = require dirname(__DIR__).'/viewer.php';

use Planviewer\MapsApi;

$mapsapi = new MapsApi([
    'auth' => [$config['api-key'], $config['api-secret']],
    'base_uri' => (isset($config['base_uri']) ? $config['base_uri'] : 'https://www.planviewer.nl'),
    'verify' => false,
]);


$identifier = $viewer['identifier'];
$layers = $mapsapi->listViewerLayers($identifier);


