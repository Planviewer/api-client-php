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

use Planviewer\Planviewer;

require dirname(__DIR__) . '/../bootstrap.php';

$planviewer = new Planviewer();

/** As this a uniquely Dutch thing the following explaination will be in Dutch  */

/**
 *
 * In dit voorbeeld halen we alle enkelbestemmingen op uit een gebied (dossiergrens).
 * Deze bestemmingsplannen worden vervolgens met elkaar chronologisch versneden.
 * het resultaat is een kaart met alle nu geldende enkelbestemmingen in het gebied.
 *
 * LET OP! Deze functie kan vele calls doen om alle informatie te verwerken. Voor dit script en gelijkende scripts
 * uit in een apart process.
 *
 */


/** create a viewer */

/** mandatory */
$data = [
    'name' => 'my-enkelebestemmingen-viewer',
];

/** optional */
$options = [
    'default_show_print' => true,
    'default_show_reset' => true,
    'default_show_measure' => true,
    'default_show_snap' => true,
];

$viewer = $planviewer->mapsApi->createViewer($data, $options)->viewer;
$viewerId = $viewer->identifier;

/** https://docs.planviewer.nl/mapsapi/server_calls/viewers.html#set-the-outline-for-the-viewer */
$options = [
  'type' => "Polygon",
  'coordinates' => '(193368.98099999999976717 447063.32900000002700835, 193360.00399999998626299 447064.17099999997299165, 193338.58799999998882413 447066.46199999999953434, 193313.70000000001164153 447069.17599999997764826, 193286.87899999998626299 447071.83399999997345731, 193258.58900000000721775 447074.6909999999916181, 193230.85899999999674037 447077.55400000000372529, 193203.05100000000675209 447080.47999999998137355, 193175.28299999999580905 447083.356000000028871, 193150.5689999999885913 447085.82099999999627471, 193116.76500000001396984 447086.49800000002142042, 193098.39400000000023283 447109.65200000000186265, 193082.91300000000046566 447124.7629999999771826, 193069.08900000000721775 447138.20500000001629815, 193057.95199999999022111 447149.08799999998882413, 193049.35099999999511056 447221.71799999999348074, 193161.49199999999837019 447210.84499999997206032, 193277.85899999999674037 447199.39500000001862645, 193386.28700000001117587 447188.79599999997299165, 193388.6279999999969732 447179.55699999997159466, 193418.54500000001280569 447064.3809999999939464, 193452.95499999998719431 447060.53399999998509884, 193480.95699999999487773 447057.40399999998044223, 193716.67499999998835847 447034.83000000001629815, 193844.72500000000582077 447020.50900000002002344, 193842.79600000000209548 447014.40799999999580905, 193834.70499999998719431 447015.20799999998416752, 193801.45300000000861473 447018.90299999999115244, 193759.34099999998579733 447023.29800000000977889, 193722.9340000000083819 447026.7629999999771826, 193693.0089999999909196 447030.0719999999855645, 193655.61300000001210719 447034.03600000002188608, 193623.78599999999278225 447037.12699999997857958, 193591.21700000000419095 447040.46899999998277053, 193558.98699999999371357 447043.66600000002654269, 193534.40200000000186265 447046.11999999999534339, 193505.52700000000186265 447049.25199999997857958, 193472.45499999998719431 447052.61300000001210719, 193444.6939999999885913 447055.4529999999795109, 193404.97500000000582077 447059.70799999998416752, 193380.62400000001071021 447062.2370000000228174, 193368.98099999999976717 447063.32900000002700835)',
];

/** set outline */
$planviewer->mapsApi->setViewerOutline($viewerId, $options);

/** Create an empty vector layer, we will be adding the geometries to this layer */
$data = [
    "name" => "My vector shape",
    "type" => "vector",
    "base" => "false",
];
$options = [
    "consultable" => true,
    "vector_uploadable" => false,
    "vector_type" => "polygon", //always use polygon for enkelbestemmingen
    "vector_drawable" => true,
];
$vectorLayer = $planviewer->mapsApi->createLayer($viewerId, $data, $options)->layer;

var_dump($vectorLayer);
/** gets the outline in correct format for the following gis calls */
$outlinedata = $planviewer->mapsApi->getViewerOutline($viewerId, 'txt');
/** Split between geometry and area */
list($srid, $outlineGeometry, $outlinearea) = explode(";", $outlinedata);


/** Now we need to shrink the outline slightly to make sure we don't create false positives later on  */
$options = [
    'geometry' => $outlineGeometry,
    'buffer' => -0.001, //units used is meters
];
$outlineShrunk = $planviewer->mapsApi->doBuffer($options);

$options = [
    'identifier' => $outlineShrunk->geometry
];

$enkelbestemmingen = $planviewer->dataApi->fetch('getenkelbestemmingbygeometry', $options);



$countedEb = count($enkelbestemmingen);
if (0 === $countedEb) {
    die('No Enkelbestemmingen found within the given geometry');
}
if (1 === $countedEb) {
    /** just one found, no need to do all the complicated stuff, just add this to the vector layer */
    $options = [
        'geometry' => $enkelbestemmingen[0]->geometry,
        'properties' => [
            'name' =>   $enkelbestemmingen[0]->naam,
            'groep' => $enkelbestemmingen[0]->bestemmingshoofdgroep,
        ],
    ];
    $planviewer->mapsApi->setPropertyVectorLayer($viewerId, $vectorLayer->id, $options);
}


//for creation only remove viewer after calls
$planviewer->mapsApi->deleteViewer($viewerId);