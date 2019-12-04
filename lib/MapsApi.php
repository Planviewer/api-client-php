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

class MapsApi extends Client {

    private $api;

    /**
     * MapsApi constructor.
     * 
     * @param array $config
     * @param array $validate
     */
    public function __construct(array $config = [], $validate = []) {

        if (!isset($config['base_uri'])) {
            $config['base_uri'] = 'https://www.planviewer.nl';
        }

        if (!isset($validate['class'])) {
            $validate['class'] = 'apiHandler';
        }

        parent::__construct($config);


        $this->api = new $validate['class']();

        if (!$this->api instanceof $validate['class']) {
            throw new \Exception('Not an instance of '. $validate['class']);
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
     * @param array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function uploadApplicatioSLD($options)
    {
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/sld/upload', $options);
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
     * @param array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getWfsCapabilities($options)
    {
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wfs', $options);
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getWmsCapabilities($options)
    {
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wms', $options);
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getWmtsCapabilities($options)
    {
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wmts', $options);
        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /* VIEWERS */
    /* https://docs.planviewer.nl/mapsapi/server_calls/viewers.html# */

    /**
     * @param array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function listViewers($options)
    {
        $this->api->isArray($options);

        $response = $this->request('GET', '/maps_api/v2/server/viewers', $options);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param array $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function createViewer($options)
    {
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers', $options);

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
    public function getViewer($viewerId = false)
    {
        $this->api->isViewerId($viewerId);

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
    public function updateViewer($viewerId = false, $updateOptions)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isArray($updateOptions);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId, $updateOptions);

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
    public function cloneViewer($viewerId = false)
    {
        $this->api->isViewerId($viewerId);

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
    public function deleteViewer($viewerId = false)
    {
        $this->api->isViewerId($viewerId);

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/delete');

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
    public function snapshotViewer($viewerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isArray($options);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/snapshot', $options);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     *
     * @throws \Exception
     */
    public function getViewerOutline($viewerId = false)
    {
        $this->api->isViewerId($viewerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/outline');

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
    public function setViewerOutline($viewerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/outline', $options);

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
    public function listLayers($viewerId = false)
    {
        $this->api->isViewerId($viewerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers');

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
    public function sortLayers($viewerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/sort_layers', $options);

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
    public function createLayer($viewerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers', $options);

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
    public function uploadShapefile($viewerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/upload', $options);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function replaceShapefile($viewerId = false, $layerId, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/upload/'.$layerId.'/upload', $options);

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
    public function getLayer($viewerId = false, $layerId = false)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function updateLayer($viewerId = false, $layerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);
        $this->api->isArray($options);

        $response = $this->request('PATCH', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId, $options);

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
    public function deleteLayer($viewerId = false, $layerId = false)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/delete');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getFeatureDataVectorLayer($viewerId = false, $layerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);
        $this->api->isArray($options);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/features', $options);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function uploadSldVectorLayer($viewerId = false, $layerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/sld/upload', $options);

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
    public function deleteSldVectorLayer($viewerId = false, $layerId = false)
    {
        $this->api->isViewerId($viewerId);
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
    public function hasSldVectorLayer($viewerId = false, $layerId = false)
    {
        $this->api->isViewerId($viewerId);
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
    public function getLegendVectorLayer($viewerId = false, $layerId = false)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/legenda');

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array $options
     * 
     * @return mixed
     * 
     * @throws \Exception
     */
    public function setPropertyVectorLayer($viewerId = false, $layerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/set_feature', $options);

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
    public function getPropertiesVectorLayer($viewerId = false, $layerId = false)
    {
        $this->api->isViewerId($viewerId);
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
    public function deletePropertyVectorLayer($viewerId = false, $layerId = false, $featureId)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/delete_properties/'.$featureId);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  $options
     * 
     * @return mixed
     * 
     * @throws \Exception
     */
    public function updatePropertyVectorLayer($viewerId = false, $layerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);
        $this->api->isArray($options);

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
    public function listFieldMapping($viewerId = false, $layerId = false)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/mappings');

        $batch = $this->api->json_decode($response);
        return $batch;
    }


    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sortFieldMapping($viewerId = false, $layerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/sort_mappings', $options);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function createFieldMapping($viewerId = false, $layerId = false, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);
        $this->api->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/mappings', $options);

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
    public function getFieldMapping($viewerId = false, $layerId = false, $mappingId)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);
        $this->api->isArray($options);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/mappings/'.$mappingId);

        $batch = $this->api->json_decode($response);
        return $batch;
    }

    /**
     * @param string $viewerId
     * @param int    $layerId
     * @param int    $mappingId
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function updateFieldMapping($viewerId = false, $layerId = false, $mappingId, $options)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);
        $this->api->isArray($options);

        $response = $this->request('PATCH', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/mappings/'.$mappingId, $options);

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
    public function deleteFieldMapping($viewerId = false, $layerId = false, $mappingId)
    {
        $this->api->isViewerId($viewerId);
        $this->api->isLayerId($layerId);
        $this->api->isArray($options);

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/mappings/'.$mappingId.'/delete');

        $batch = $this->api->json_decode($response);
        return $batch;
    }
}
