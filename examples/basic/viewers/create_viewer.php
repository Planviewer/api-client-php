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

$mapsapi = require dirname(__DIR__).'/../bootstrap.php';

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

$viewer = $mapsapi->createViewer($data, $options)->viewer;

var_dump($viewer);
