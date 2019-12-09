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

class MapsApi extends Client
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

        if(null === $apiHandler) {
            $apiHandler = new apiHandler();
        }

        $this->api = $apiHandler;
    }

    /* APPLICATION */
    /* https://docs.planviewer.nl/mapsapi/server_calls/application.html# */

    /**
     * @return mixed
     */
    public function listLayerTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/layer_types');
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @return mixed
     */
    public function listVectorSourceTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/vector_source_types');
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @return mixed
     */
    public function listFeatureExportTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/feature_export_types');
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @return mixed
     */
    public function listImageExportTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/image_export_types');
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @return mixed
     */
    public function listFieldMappingTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/mapping_types');
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param array array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadApplicatioSLD(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/sld/upload', [
            'json' => $options,
        ]);
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @return mixed
     */
    public function deleteApplicatioSLD()
    {
        $response = $this->request('DELETE', '/maps_api/v2/server/sld/delete');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @return mixed
     */
    public function hasApplicatioSLD()
    {
        $response = $this->request('GET', '/maps_api/v2/server/sld');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @return mixed
     */
    public function getDefaultLegenda()
    {
        $response = $this->request('GET', '/maps_api/v2/server/legenda/default');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param array array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWfsCapabilities(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wfs', [
            'json' => $options,
        ]);
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $url
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWmsCapabilities(string $url)
    {
        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wms', [
            'json' => [
                'url' => $url,
            ]
        ]);
        $layers = $this->api->json_decode($response);
        return $layers;
    }

    /**
     * @param array array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWmtsCapabilities(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wmts', [
            'json' => $options,
        ]);
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /* VIEWERS */
    /* https://docs.planviewer.nl/mapsapi/server_calls/viewers.html# */

    /**
     * @param int $offset 
     * @param int $limit 
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listViewers(int $offset, int $limit)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers', [
            'query' => [
                'offset' => $offset,
                'limit' => $limit,
            ]
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param array $data
     * @param array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createViewer(array $data, array $options = [])
    {
        $data = array_merge($data, [
            'default_show_print' => true,
            'default_show_reset' => true,
            'default_show_measure' => true,
            'default_show_snap' => true,
        ], $options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers', [
            'json' => $data,
        ]);

        $viewer = $this->api->json_decode($response);
        return $viewer;
    }

    /**
     * @param string $identifier
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getViewer(string $identifier)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$identifier);

        $viewer = $this->api->json_decode($response);
        return $viewer;
    }

    /**
     * @param string $identifier
     * @param array $updateOptions
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateViewer(string $identifier, array $updateOptions)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier, [
            'json' => $updateOptions,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cloneViewer(string $identifier)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/clone');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteViewer(string $identifier)
    {
        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/' . $identifier . '/delete');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function snapshotViewer(string $identifier, array $options)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers/' . $identifier . '/snapshot', [
            'query' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getViewerOutline(string $identifier, $format = 'json')
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers/' . $identifier . '/outline.'.$format);

        if ('json' === $format) {
            $batch = $this->api->json_decode($response);
            return $batch;
        }

        return $response->getBody()->getContents();
    }

    /**
     * @param string $identifier
     * @param array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setViewerOutline(string $identifier, array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/set_outline', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /* LAYERS */
    /* https://docs.planviewer.nl/mapsapi/server_calls/layers.html# */

    /**
     * @param string $identifier
     * @param int $layerId
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listLayers(string $identifier)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers/' . $identifier . '/layers');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sortLayers(string $identifier, array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/sort_layers', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param array  $data
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createLayer(string $identifier, array $data, array $options = [])
    {
        $data = array_merge($data, [
            'base' => false,
            'consultable' => true,
            'show_layer' => true,
            'use_transparancy' => true,
        ], $options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$identifier.'/layers', [
            'json' => $data
        ]);

        $layer = $this->api->json_decode($response);
        return $layer;
    }

    /**
     * @param string $identifier
     * @param array  $data
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadShapefile(string $identifier, array $data)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$identifier.'/upload', [
            'json' => $data,
        ]);

        $layer = $this->api->json_decode($response);
        return $layer;
    }

    /**
     * @param string $identifier
     * @param int    $layer
     * @param array  $data
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function replaceShapefile(string $identifier, int $layer, array $data, array $options = [])
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$identifier.'/layers/'.$layer.'/upload', [
            'json' => $data,
        ]);

        $layer = $this->api->json_decode($response);
        return $layer;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLayer(string $identifier, integer $layerId)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateLayer(string $identifier, integer $layerId, array $options)
    {
        $response = $this->request('PATCH', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId, [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteLayer(string $identifier, integer $layerId)
    {
        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/delete');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFeatureDataVectorLayer(string $identifier, integer $layerId, array $options)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/features', [
            'query' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadSldVectorLayer(string $identifier, integer $layerId, array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/sld/upload', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteSldVectorLayer(string $identifier, integer $layerId)
    {
        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/sld/delete');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function hasSldVectorLayer(string $identifier, integer $layerId)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/sld');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLegendVectorLayer(string $identifier, integer $layerId)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/legenda');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     * @param array array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setPropertyVectorLayer(string $identifier, $layerId, array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/set_feature', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPropertiesVectorLayer(string $identifier, integer $layerId)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/get_properties');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     * @param int $featureId
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deletePropertyVectorLayer(string $identifier, integer $layerId, $featureId)
    {
        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/delete_properties/' . $featureId);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updatePropertyVectorLayer(string $identifier, integer $layerId)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/update_feature');

        $batch = $this->api->json_decode($response);
        return $batch;
    }


    /* Field mappings */
    /* https://docs.planviewer.nl/mapsapi/server_calls/mappings.html# */

    /**
     * @param string $identifier
     * @param int $layerId
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listFieldMapping(string $identifier, integer $layerId)
    {

        $this->api->isLayerId($layerId);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/mappings');

        $batch = $this->api->json_decode($response);
        return $batch;
    }


    /**
     * @param string $identifier
     * @param int $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sortFieldMapping(string $identifier, integer $layerId, array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/sort_mappings', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createFieldMapping(string $identifier, integer $layerId, array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/mappings', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     * @param int $mappingId
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFieldMapping(string $identifier, integer $layerId, $mappingId)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/mappings/' . $mappingId);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     * @param int $mappingId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateFieldMapping(string $identifier, integer $layerId, $mappingId, array $options)
    {
        $response = $this->request('PATCH', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/mappings/' . $mappingId, [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param int $layerId
     * @param int $mappingId
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteFieldMapping(string $identifier, integer $layerId, $mappingId)
    {
        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/' . $identifier . '/layers/' . $layerId . '/mappings/' . $mappingId . '/delete');

        $batch = $this->api->json_decode($response);
        return $batch;
    }


    /* GEOMETRY */
    /* https://docs.planviewer-staging.nl/mapsapi/geometry.html# */

    public function getArea(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/gis/area', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    public function doBuffer(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/gis/buffer', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    public function doIntersection(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/gis/intersection', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

}
