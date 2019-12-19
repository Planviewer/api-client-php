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
 * Example listing Product order
 *
 * @see https://docs.planviewer.nl/productapi/index.html#
 */

use Planviewer\Planviewer;

require dirname(__DIR__).'/../bootstrap.php';

/** $config is build up in bootstrap.php. take a look at the file to see how it's configured  */
$planviewer = new Planviewer($config);


/** get product list */
$products = $planviewer->productApi->getProducts();


/** We'll take the percelenrapport as the product we want */
$product = $products[1]->slug;

/** Let's do a search on address */
$options = [
    'entity' => 'adres',
    'query' => [
        'bool' => [
            'must' => [
                [
                    'field' => [
                        'fields' => [
                            "postcode"
                        ],
                        'query' => '3081BG' //NO SPACES
                    ]
                ],
                [
                    'field' => [
                        'fields' => [
                            "huisnummer"
                        ],
                        'query' => '63'
                    ],
                ],
                [
                    'field' => [
                        'fields' => [
                            "huisletter"
                        ],
                        'query' => 'C'
                    ],
                ],
            ],
        ],
    ],
];


$searchResult = $planviewer->productApi->locationSearch($options);

/** we'll take the id from the first adres found */
$adresUuid = $searchResult[0]->uuid;

/** now lets see if there are products available for this address */
$options = [
    'uuids' => [$adresUuid],
    'products' => [$product],
];

$availableProducts = $planviewer->productApi->getAvailableProducts($options);

if (0 === sizeof($availableProducts)) {
    die("No products found");
}

/** Let's order the first product */
$options = [
    "uuids" => [
        $availableProducts[0]->intentions[0]->uuid
        ],
    ];



$order = $planviewer->productApi->placeOrder($options);


/** as we only order one product we can start poling if it has been generated */
$ready = false;

/** depending on the product the generation can take a few minutes */
while(!$ready) {
    $options = [
      "uuids" =>[$order[0]->job->uuid]
    ];
    $status = $planviewer->productApi->getOrderStatus($options);
    /** If finished, stop the loop and lets download the product */
    if ('finished' === $status[0]->status) {
        $ready = true;
        $orderUuid = $status[0]->uuid;
    }
    /** If generation failes kill the script */
    if ('error' === $status[0]->status) {
        die("Product failed to generate");
    }
    //retry in 1 second
    usleep(1000);
}

/** download the product */
$product = $planviewer->productApi->getOrder($orderUuid);
header("Content-type: application/pdf");
echo $product;



