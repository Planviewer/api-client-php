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

use Planviewer;

require dirname(__DIR__).'/../bootstrap.php';

/** $config is build up in bootstrap.php. take a look at the file to see how it's configured  */
$planviewer = new Planviewer\Planviewer($config);


/** available layer-types */
$types = $planviewer->mapsApi->listLayerTypes();

/** create viewer for example */
/** mandatory */
$data = [
    'name' => 'my-viewer-with-bestemmingsplannen-layer',
];

/** optional */
$options = [
    'default_show_print' => true,
    'default_show_reset' => true,
    'default_show_measure' => true,
    'default_show_snap' => true,
];

/** Create viewer for this example */
$viewer = $planviewer->mapsApi->createViewer($data, $options);

/* layer options */
/** mandatory for bestemmingsplannen layer */
$data = [
    'name' => 'my-bestemmingsplannen-layer',

    /** must be one of $types */
    'type' => 'imro',

];

/** options */
$options = [
    'base' => false,
    'consultable' => true,
    'show_layer' => true,
];


$layer = $planviewer->mapsApi->createLayer($viewer->viewer->identifier,$data, $options);

var_dump($layer);