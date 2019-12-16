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

require dirname(__DIR__) . '/../bootstrap.php';

/** $config is build up in bootstrap.php. take a look at the file to see how it's configured  */
$planviewer = new Planviewer\Planviewer($config);

/** available layer-types */
$types = $planviewer->mapsApi->listLayerTypes();

/** allowed vector types */
$vectorSourceTypes = $planviewer->mapsApi->ListVectorSourceTypes();


/** target viewer for these examples */
/** mandatory */
$data = [
    'name' => 'my-new-viewer',
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

/** 
 * upload shapefile to create a new layer 
 */
$data = [
    'layer_name' => 'my-first-vector-layer',

    /** one of $vectorSourceTypes */
    'type' => 'polygon',

    'file' => [
        'name' => 'my-shapefile.zip',
        'content' => base64_encode(file_get_contents(dirname(__FILE__).'/files/my-shapefile.zip')),
    ],
];


/** uploadShapefile will create a new layer automatically */
$layer = $planviewer->mapsApi->uploadShapefile($identifier, $data);
var_dump($layer);


/**
 * or upload a new shape to an existing vector-layer
 */
$data = [
    'name' => 'my-second-vector-layer',
    'type' => 'vector',
    'vector_type' => 'polygon',
];

$options = [];

$layer = $planviewer->mapsApi->createLayer($identifier, $data, $options)->layer;

$data = [
    'file' => [
        'name' => 'my-shapefile.zip',
        'content' => base64_encode(file_get_contents(dirname(__FILE__).'/files/my-shapefile.zip')),
    ],
];

$layer = $planviewer->mapsApi->replaceShapefile($identifier, $layer->id, $data);
var_dump($layer);



