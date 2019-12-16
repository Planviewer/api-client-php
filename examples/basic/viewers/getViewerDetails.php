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

require dirname(__DIR__).'/../bootstrap.php';

/** $config is build up in bootstrap.php. take a look at the file to see how it's configured  */
$planviewer = new Planviewer\Planviewer($config);

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

/** returns an array containing all settings and API urls for this viewer */
$viewer = $planviewer->mapsApi->getViewer($viewer->identifier);
var_dump($viewer);
