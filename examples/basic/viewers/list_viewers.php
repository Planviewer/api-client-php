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

$planviewer = new Planviewer\Planviewer();

/** paged list */
$limit = 10;
$offset = 0;
$viewers = [];
do {

    $batch = $planviewer->mapsApi->listViewers($offset, $limit);
    $viewers = array_merge($viewers, $batch->viewers);
    $offset += $limit;

} while(count($batch->viewers));

var_dump($viewers);
