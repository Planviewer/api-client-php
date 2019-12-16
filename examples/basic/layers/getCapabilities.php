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

require dirname(__DIR__) . '/../bootstrap.php';

/** $config is build up in bootstrap.php. take a look at the file to see how it's configured  */
$planviewer = new Planviewer($config);


/** all URL's used in this example can be found on pdok.nl */

$wmsUrl = "https://geodata.nationaalgeoregister.nl/bestandbodemgebruik2015/wms?";

$capabilities = $planviewer->mapsApi->getWmsCapabilities(['url' => $wmsUrl]);

var_dump("WMS");
var_dump($capabilities);

$wfsUrl = "https://geodata.nationaalgeoregister.nl/ahn2/wfs?";
$capabilities = $planviewer->mapsApi->getWfsCapabilities(['url' => $wfsUrl]);

var_dump("WFS");
var_dump($capabilities);


$wmtsUrl = "https://geodata.nationaalgeoregister.nl/tiles/service/wmts/bgtstandaardv2?&request=GetCapabilities&service=WMTS";
$capabilities = $planviewer->mapsApi->getWmtsCapabilities(['url' => $wmtsUrl]);

var_dump("WMTS");
var_dump($capabilities);