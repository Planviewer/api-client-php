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

use Classes\apiInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class Planviewer
{
    private $config;

    public $mapsApi;

    public $dataApi;

    public $productApi;

    public function __construct(apiInterface $apiHandler = null)
    {
        $config = require __DIR__ . '../../config/config.php';
        $this->config = [
            'auth' => [$config['api-key'], $config['api-secret']],
            'base_uri' => (isset($config['base_uri']) ? $config['base_uri'] : 'https://www.planviewer.nl'),
            'verify' => false,
        ];
        $this->mapsApi = new MapsApi($this->config, $apiHandler);
        $this->dataApi = new DataApi($this->config, $apiHandler);
        $this->productApi = new ProductApi($this->config, $apiHandler);

    }
}