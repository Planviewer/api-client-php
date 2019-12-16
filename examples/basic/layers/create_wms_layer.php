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

require dirname(__DIR__).'/../bootstrap.php';

/** $config is build up in bootstrap.php. take a look at the file to see how it's configured  */
$planviewer = new Planviewer\Planviewer($config);

/** available layer-types */
$types = $planviewer->mapsApi->listLayerTypes();

/** fetch available layers from WMS service */
$layers = $planviewer->mapsApi->getWmsCapabilities('https://geodata.nationaalgeoregister.nl/ahn1/wms');



/** create viewer for example */
/** mandatory */
$data = [
    'name' => 'my-viewer-with-wms-layer',
];

/** optional */
$options = [
    'default_show_print' => true,
    'default_show_reset' => true,
    'default_show_measure' => true,
    'default_show_snap' => true,
];

$viewer = $planviewer->mapsApi->createViewer($data, $options)->viewer;

$identifier = $viewer->identifier;

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

$layer = $planviewer->mapsApi->createLayer($identifier, $data, $options);
var_dump($layer);


