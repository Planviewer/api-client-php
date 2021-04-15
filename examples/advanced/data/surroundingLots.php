<?php

/**
 * Copyright (c) 2021 Planviewer BV.
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


use Planviewer\Planviewer;

require dirname(__DIR__).'/data/../../bootstrap.php';

/** $config is build up in bootstrap.php. take a look at the file to see how it's configured  */
$planviewer = new Planviewer($config);

/** USE THIS EXAMPLE TO get the lots surrounding the target lot */
$perceelnummer = [
    "kadastrale_gemeente" => "ELST",
    "sectie" => "M",
    "perceelnummer" => "17"
];
$baseLot = $planviewer->dataApi->getgeometrybyperceel($perceelnummer); //Docs: https://docs.planviewer.nl/mapsapi/data_api.html#post--maps_api-v2-server-data-getgeometrybyperceel

//enlarge the geometry of the base lot with a meter.
$data = [
    "geometry" => $baseLot->geometry,
    "buffer" => 1 //in meters
];
$enlargedBaseLot = $planviewer->mapsApi->doBuffer($data); //Docs: https://docs.planviewer.nl/mapsapi/geometry.html#post--maps_api-v2-server-gis-buffer

/** now we are going to get all lots that touch this larger geometry */
$identifier = [
    'identifier' => $enlargedBaseLot->geometry,
];
$touchedLots = $planviewer->dataApi->fetch('getperceelgeometrybygeometry', $identifier); //Docs: https://docs.planviewer.nl/mapsapi/data_api.html#data-collection-calls List: https://www.planviewer.nl/Api/data/list

/**
 * The resulting list contains current and old lots as Planviewer provides the complete digital history of the locations.
 * In this example we are going to use the current lots only
 * Therefore we must filter out the old "dissapeared" lots
*/
$currentLots = [];

foreach ($touchedLots as $touchedLot) {
    if (null === $touchedLot->disappeared && null === $touchedLot->vervallen) {
        /**
         * while looping through it to get the current lots we can also remove the base lot from this array by comparing the EWKT geom strings
         */
        if ($touchedLot->geometry !== $baseLot->geometry) {
            array_push($currentLots, $touchedLot);
        }
    }
}

/**
 * now we have the geometries of all current lots, if that's all you need then fine, you're done.
 * If you want to add the kadstrale aanduiding to you will have to enrich the data further
 */
$finalLots = [];
foreach ($currentLots as $currentLot) {

    // shrink the geometry as so to not touch the surrounding lots
    $data = [
        "geometry" => $currentLot->geometry,
        "buffer" => -0.001 //in meters
    ];
    $geom = $planviewer->mapsApi->doBuffer($data)->geometry;

    $lots = $planviewer->dataApi->fetch('getpercelenbygeometry', ['identifier' => $geom]);
    /** again you will also recieve historic data to make sure your dataset contains the current lots */
    foreach ($lots as $lot) {
        if (null === $lot->disappeared && null === $lot->vervallen) {
            $lot->gemeentenaam = $planviewer->dataApi->fetch('getgemeentenaambygemeentecode', ['identifier' => $lot->gemeentecode])[0]->gemeentenaam; //adds the manicupalities name to the object
            array_push($finalLots, $lot);
        }
    }
}

/**
 * The $finalLots now contain the surrounding lots with the kadastrale aanduiding.
 * The following code will visualize the data in a viewer.
 * If you only need to handle the information in an administrative manner then this portion of the example can be ignored.
 */

/**
 * create a new viewer
 */
$data = [
    'name' => 'surrounding lots',
    'limit_extent' => false,
    'info_text' => 'This viewer was created from the example script: finding surrounding lots'
];
$viewer = $planviewer->mapsApi->createViewer($data); //Docs: https://docs.planviewer.nl/mapsapi/server_calls/viewers.html#post--maps_api-v2-server-viewers

/**
 * display the url for the viewer in the console
 */
echo $viewer->viewer->viewer_embed_url.PHP_EOL;

/**
 * we are going to set an outline (working area) for the viewer on the base lot
 */
$data = [
    'type' => 'Ewkt',
    'coordinates' => $baseLot->geometry
];

$outline = $planviewer->mapsApi->setViewerOutline($viewer->viewer->identifier, $data); //Docs: https://docs.planviewer.nl/mapsapi/server_calls/viewers.html#post--maps_api-v2-server-viewers-(string-identifier)-set_outline

/**
 * we are going to create a vector layer with all the lots depicted in them
 */
$data = [
    'name' => 'Lots',
    'type' => 'vector', //Docs https://docs.planviewer.nl/mapsapi/server_calls/application.html#get--maps_api-v2-server-layer_types
    'consultable' => true,
    'use_transparancy' => true,
    'vector_uploadable' => false,
    'vector_drawable' => false,
    'vector_type' => 'polygon', //Docs https://docs.planviewer.nl/mapsapi/server_calls/application.html#get--maps_api-v2-server-vector_source_types
    'as_wms' => true,
];
$vectorLayer = $planviewer->mapsApi->createLayer($viewer->viewer->identifier, $data); //Docs: https://docs.planviewer.nl/mapsapi/server_calls/layers.html#post--maps_api-v2-server-viewers-(string-identifier)-layers

/**
 * now we have an empty vector layer which we are going to fill
 * let start with the baselot
 */
$data = [
    'geometry' => $baseLot->geometry,
    'properties' => [
        "kadastrale_gemeente" => "ELST",
        "sectie" => "M",
        "perceelnummer" => "17",
    ],
];
$planviewer->mapsApi->setPropertyVectorLayer($viewer->viewer->identifier, $vectorLayer->layer->id, $data); //Docs: https://docs.planviewer.nl/mapsapi/server_calls/layers.html#post--maps_api-v2-server-viewers-(string-identifier)-layers-(int-layer)-set_feature
/**
 * now we are going to add all the surrounding lots
 */

foreach ($finalLots as $lot) {
    $data = [
        'geometry' => $lot->geometry,
        'properties' => [
            "kadastrale_gemeente" => $lot->gemeentenaam,
            "sectie" => $lot->sectie,
            "perceelnummer" => $lot->perceelnummer,
        ],
    ];
    // just repeat the call
    $planviewer->mapsApi->setPropertyVectorLayer($viewer->viewer->identifier, $vectorLayer->layer->id, $data);
}

/**
 * the viewer now contains all the data gather with the data api and visualized with the maps api.
 */

