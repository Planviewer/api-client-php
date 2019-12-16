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

use Planviewer\Planviewer;

require dirname(__DIR__).'/../bootstrap.php';

/** $config is build up in bootstrap.php. take a look at the file to see how it's configured  */
$planviewer = new Planviewer($config);

/** YOU'LL NEED A VIEWER FOR A SNAPSHOT */


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

/** list all layers */

$layers = $planviewer->mapsApi->listLayers($viewer->identifier)->layers;

var_dump($layers);

/** we are going to reverse the sorting of the layers */
$newSorting = [];

foreach ($layers as $layer) {
    $newSorting[$layer->sort_order] = $layer->id;
}

var_dump($newSorting);
rsort($newSorting);
var_dump($newSorting);

foreach ($newSorting as $key => $val) {
    $layerSorting[] = [
      'id' => $val,
      'sort_order' => $key
    ];
}

$options = [
    'layers' => $layerSorting,
];

$sorted = $planviewer->mapsApi->sortLayers($viewer->identifier, $options);
var_dump($sorted);