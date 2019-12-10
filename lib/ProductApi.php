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
use Planviewer\Tools\ApiInterface;
use Planviewer\Tools\ApiHandler;

class ProductApi extends Client
{

    private $api;

    /**
     * MapsApi constructor.
     *
     * @param array $config
     * @param object $apiHandler
     */
    public function __construct(array $config = [], ApiInterface $apiHandler = null)
    {

        if (!isset($config['base_uri'])) {
            $config['base_uri'] = 'https://www.planviewer.nl';
        }

        parent::__construct($config);

        $this->api = $apiHandler;

        if (null === $apiHandler) {
            $this->api = new ApiHandler();
        }
    }

    /* PRODUCTS */
    /* https://docs.planviewer.nl/productapi/products.html# */

    /**
     * @return mixed
     */
    public function getProducts()
    {
        $response = $this->request('GET', '/product_api/v1/products/list');
        $batch = $this->api->json_decode($response);

        return $batch;
    }

    /**
     * @param array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function locationSearch(array $options)
    {
        $response = $this->request('POST', '/product_api/v1/search/structured', [
            'json' => $options,
        ]);
        $batch = $this->api->json_decode($response);

        return $batch;
    }

    /**
     * @param array $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAvailableProducts(array $options)
    {
        $response = $this->request('POST', '/product_api/v1/intentions/list', [
            'json' => $options,
        ]);
        $batch = $this->api->json_decode($response);

        return $batch;
    }

    /**
     * @param array $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function placeOrder(array $options)
    {
        $response = $this->request('POST', '/product_api/v1/jobs/order', [
            'json' => $options,
        ]);
        $batch = $this->api->json_decode($response);

        return $batch;
    }

    /**
     * @param array $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOrderStatus(array $options)
    {
        $response = $this->request('POST', '/product_api/v1/jobs/status', [
            'json' => $options,
        ]);
        $batch = $this->api->json_decode($response);

        return $batch;
    }

    /**
     * @param array $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOrder(array $options)
    {
        $response = $this->request('GET', '/product_api/v1/jobs/status', [
            'query' => $options,
        ]);
        $batch = $this->api->json_decode($response);

        return $batch;
    }

}