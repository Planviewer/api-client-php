<?php

declare(strict_types=1);

/**
 * Copyright (c) 2019 Planviewer BV.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/Planviewer/api-client-php
 */

namespace Planviewer;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use apiInterface;

class DataApi extends Client
{

    private $api;

    /**
     * MapsApi constructor.
     *
     * @param array $config
     * @param object $apiHandler
     */
    public function __construct(array $config = [], apiInterface $apiHandler = null)
    {

        if (!isset($config['base_uri'])) {
            $config['base_uri'] = 'https://www.planviewer.nl';
        }

        parent::__construct($config);

        $this->api = $apiHandler;

        if (null === $apiHandler) {
            $this->api = new apiHandler();
        }
    }

    /* GEOCODING */
    /* https://docs.planviewer.nl/mapsapi/data_api.html#get-geometry-of-an-address */
}