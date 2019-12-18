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

var_dump($products);

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

var_dump($availableProducts);

