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

        $this->api = $apiHandler;

        if (null === $apiHandler) {
            $this->api = new apiHandler();
        }
    }

    /* APPLICATION */
    /* https://docs.planviewer.nl/mapsapi/server_calls/application.html# */

    /**
     * @return mixed
     */
    public function ListLayerTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/layer_types');
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @return mixed
     */
    public function ListVectorSourceTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/vector_source_types');
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @return mixed
     */
    public function ListFeatureExportTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/feature_export_types');
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @return mixed
     */
    public function ListImageExportTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/image_export_types');
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @return mixed
     */
    public function ListFieldMappingTypes()
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @param array array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getWmsCapabilities(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wms', [
            'json' => $options,
        ]);
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param array array $options
     *
     * @return mixed
     *
     * @throws \Exception
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
     * @param array array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function listViewers(array $options)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers', [
            'query' => $options
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param array array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function createViewer(array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getViewer(string $identifier)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers/' . $identifier);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param array $updateOptions
     *
     * @return mixed
     *
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
     */
    public function getViewerOutline(string $identifier)
    {
        $response = $this->request('GET', '/maps_api/v2/server/viewers/' . $identifier . '/outline');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function setViewerOutline(string $identifier, array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/outline', [
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @param array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function createLayer(string $identifier, array $options)
    {

        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/layers', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $identifier
     * @param array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function uploadShapefile(string $identifier, array $options)
    {

        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/upload', [
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
     * @throws \Exception
     */
    public function replaceShapefile(string $identifier, integer $layerId, array $options)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/' . $identifier . '/upload/' . $layerId . '/upload', [
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
     */
    public function setPropertyVectorLayer(string $identifier, integer $layerId, array $options)
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
     */
    public function listFieldMapping(string $identifier, integer $layerId)
    {

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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
