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

$vectorSourceTypes = $mapsapi->ListVectorSourceTypes();
var_dump($vectorSourceTypes);

/** mandatory for vector layer */
$data = [
    'layer_name' => 'my-first-vector-layer',

    /** one of $vectorSourceTypes */
    'type' => 'polygon',

    'file' => [
        'name' => 'my-shapefile.zip',
        'content' => base64_encode(file_get_contents(dirname(__FILE__).'/files/my-shapefile.zip')),
    ],
];

/** target viewer for these examples */
$viewer = require dirname(__FILE__).'/viewer.php';
$identifier = $viewer['identifier'];

/** upload shapefile to create a new layer */
$layer = $mapsapi->uploadShapefile($identifier, $data);
var_dump($layer);



$data = [
    'name' => 'my-second-vector-layer',
    'type' => 'vector',
    'vector_type' => 'polygon',
];

$options = [];

/** or upload a new shape to an existing vector-layer */
$layer = $mapsapi->createLayer($identifier, $data, $options)->layer;

$data = [
    'file' => [
        'name' => 'my-shapefile.zip',
        'content' => base64_encode(file_get_contents(dirname(__FILE__).'/files/my-shapefile.zip')),
    ],
];

$layer = $mapsapi->replaceShapefile($identifier, $layer->id, $data);
var_dump($layer);



