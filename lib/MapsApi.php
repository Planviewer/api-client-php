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

class MapsApi extends Client {

    private $api;

    /**
     * MapsApi constructor.
     * 
     * @param array  $config
     * @param object $apiHandler
     */
    public function __construct(array $config = [], apiInterface $apiHandler = null) {

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
     * @param string $viewerId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getViewer(string $viewerId)
    {
        

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param array $updateOptions
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function updateViewer(string $viewerId, array $updateOptions)
    {
        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId, [
            'json' => $updateOptions,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function cloneViewer(string $viewerId)
    {
        
        
        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/clone');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function deleteViewer(string $viewerId)
    {
        

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/delete');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function snapshotViewer(string $viewerId, array $options)
    {
        
        

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/snapshot', [
            'query' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     *
     * @throws \Exception
     */
    public function getViewerOutline(string $viewerId)
    {
        

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/outline');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function setViewerOutline(string $viewerId, array $options)
    {
        
        

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/outline', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /* LAYERS */
    /* https://docs.planviewer.nl/mapsapi/server_calls/layers.html# */

    /**
     * @param string $viewerId
     * @param int    $layerId
     *
     * @throws \Exception
     */
    public function listLayers(string $viewerId)
    {
        

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sortLayers(string $viewerId, array $options)
    {
        
        

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/sort_layers', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function createLayer(string $viewerId, array $options)
    {
        
        

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function uploadShapefile(string $viewerId, array $options)
    {

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/upload', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function replaceShapefile(string $viewerId,integer $layerId, array $options)
    {
        
        $this->api->isLayerId($layerId);
        

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/upload/'.$layerId.'/upload', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getLayer(string $viewerId,integer $layerId)
    {
        
        $this->api->isLayerId($layerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function updateLayer(string $viewerId,integer $layerId, array $options)
    {
        
        $this->api->isLayerId($layerId);
        

        $response = $this->request('PATCH', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId, [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function deleteLayer(string $viewerId,integer $layerId)
    {
        
        $this->api->isLayerId($layerId);

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/delete');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getFeatureDataVectorLayer(string $viewerId,integer $layerId, array $options)
    {
        
        $this->api->isLayerId($layerId);
        

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/features', [
            'query' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function uploadSldVectorLayer(string $viewerId,integer $layerId, array $options)
    {
        $this->api->isLayerId($layerId);
        

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/sld/upload', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function deleteSldVectorLayer(string $viewerId,integer $layerId)
    {
        
        $this->api->isLayerId($layerId);

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/sld/delete');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function hasSldVectorLayer(string $viewerId,integer $layerId)
    {
        
        $this->api->isLayerId($layerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/sld');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getLegendVectorLayer(string $viewerId,integer $layerId)
    {
        
        $this->api->isLayerId($layerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/legenda');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array array $options
     * 
     * @return mixed
     * 
     * @throws \Exception
     */
    public function setPropertyVectorLayer(string $viewerId,integer $layerId, array $options)
    {
        
        $this->api->isLayerId($layerId);
        

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/set_feature', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * 
     * @return mixed
     * 
     * @throws \Exception
     */
    public function getPropertiesVectorLayer(string $viewerId,integer $layerId)
    {
        
        $this->api->isLayerId($layerId);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/get_properties');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param int    $featureId
     * 
     * @return mixed
     * 
     * @throws \Exception
     */
    public function deletePropertyVectorLayer(string $viewerId,integer $layerId, $featureId)
    {
        
        $this->api->isLayerId($layerId);

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/delete_properties/'.$featureId);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  array $options
     * 
     * @return mixed
     * 
     * @throws \Exception
     */
    public function updatePropertyVectorLayer(string $viewerId,integer $layerId)
    {
        
        $this->api->isLayerId($layerId);
        

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/update_feature');

        $batch = $this->api->json_decode($response);
        return $batch;
    }


    /* Field mappings */
    /* https://docs.planviewer.nl/mapsapi/server_calls/mappings.html# */

    /**
     * @param string $viewerId
     * @param int    $layerId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function listFieldMapping(string $viewerId,integer $layerId)
    {
        
        $this->api->isLayerId($layerId);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/mappings');

        $batch = $this->api->json_decode($response);
        return $batch;
    }


    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sortFieldMapping(string $viewerId,integer $layerId, array $options)
    {
        
        $this->api->isLayerId($layerId);
        

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/sort_mappings', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function createFieldMapping(string $viewerId,integer $layerId, array $options)
    {
        
        $this->api->isLayerId($layerId);
        

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/mappings', [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param int    $mappingId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getFieldMapping(string $viewerId,integer $layerId, $mappingId)
    {
        
        $this->api->isLayerId($layerId);
        

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/mappings/'.$mappingId);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param int    $mappingId
     * @param array  array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function updateFieldMapping(string $viewerId,integer $layerId, $mappingId, array $options)
    {
        
        $this->api->isLayerId($layerId);
        

        $response = $this->request('PATCH', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/mappings/'.$mappingId, [
            'json' => $options,
        ]);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param int    $mappingId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function deleteFieldMapping(string $viewerId,integer $layerId, $mappingId)
    {
        
        $this->api->isLayerId($layerId);
        

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/mappings/'.$mappingId.'/delete');

        $batch = $this->api->json_decode($response);
        return $batch;
    }
}
