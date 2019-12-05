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
use Classes\apiInterface;
use Classes\apiHandler;

class DataApi extends Client
{

    private $api;

    /**
     * MapsApi constructor.
     *
     * @param array  $config
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


    /**
     * @param array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getgeometrybyaddress(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/data/getgeometrybyaddress', [
            'json' => $options,
        ]);

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
    public function getgeometrybyperceel(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/data/getgeometrybyperceel', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /* Data Collection */
    /* https://docs.planviewer.nl/mapsapi/data_api.html#data-collection-calls */

    public function getdataList(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/data/list');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $endpoint
     * @param array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetch(string $endpoint, array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/data/fetch/'.$endpoint, [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /* SPECIALIZED CALLS */
    /* https://docs.planviewer.nl/mapsapi/data_api.html#specialized-calls */

    /**
     * @param array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBuildingElevation(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/data/pointcloud/building/elevation', [
            'json' => $options,
        ]);

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
    public function getBuildingVolume(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/data/pointcloud/building/volume', [
            'json' => $options,
        ]);

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
    public function getBuildingSurface(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/data/pointcloud/building/surface', [
            'json' => $options,
        ]);

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
    public function getBuildingHighestpoint(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/data/pointcloud/building/highestpoint', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }
}
