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
 * Example create a new layer for a viewer
 *
 * @see https://docs.planviewer.nl/mapsapi/server_calls/layers.html#create-a-new-layer-for-a-viewer
 */

$mapsapi = require dirname(__DIR__).'/../bootstrap.php';

/** available layer-types */
$types = $mapsapi->listLayerTypes();
var_dump($types);

/** fetch available layers from WMS service */
$layers = $mapsapi->getWmsCapabilities('https://geodata.nationaalgeoregister.nl/ahn1/wms');
var_dump($layers);

/** mandatory for WMS layer */
$data = [
    'name' => 'my-wms-layer',
    'wms_url' => 'https://geodata.nationaalgeoregister.nl/ahn1/wms',

    /** must be one of $types */
    'type' => 'wms',

    /** one of $layers from capabilities */
    'wms_layer_name' => 'ahn1_100m',
];

/** options */
$options = [
    'base' => false,
    'consultable' => true,
    'show_layer' => true,
];

/** target viewer for these examples */
$viewer = require dirname(__FILE__).'/viewer.php';
$identifier = $viewer['identifier'];

$layer = $mapsapi->createLayer($identifier, $data, $options);
var_dump($layer);


