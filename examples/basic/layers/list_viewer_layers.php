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

$mapsapi = require dirname(__DIR__).'/../bootstrap.php';

/** target viewer for these examples */
$viewer = require dirname(__FILE__).'/viewer.php';
$identifier = $viewer['identifier'];

$layers = $mapsapi->listLayers($identifier);
var_dump($layers);


