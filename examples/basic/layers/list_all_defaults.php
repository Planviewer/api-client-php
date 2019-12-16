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

use Planviewer\Planviewer;

require dirname(__DIR__).'/../bootstrap.php';

/** $config is build up in bootstrap.php. take a look at the file to see how it's configured  */
$planviewer = new Planviewer($config);

var_dump($config);

/** In this example we create a viewer to be able to list the layers */

var_dump("Available Layer Types");

$list = $planviewer->mapsApi->listLayerTypes();
var_dump($list);

var_dump("Available Vector Source Types");

$list = $planviewer->mapsApi->listVectorSourceTypes();
var_dump($list);

var_dump("Available feature Export Types");

$list = $planviewer->mapsApi->listFeatureExportTypes();
var_dump($list);

var_dump("Available Image Export Types");

$list = $planviewer->mapsApi->listImageExportTypes();
var_dump($list);

var_dump("Available Field Mapping Types");

$list = $planviewer->mapsApi->listFieldMappingTypes();
var_dump($list);


