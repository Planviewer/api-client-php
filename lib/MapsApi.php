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

    public function __construct(array $config = []) {

        if(!isset($config['base_uri'])) {
            $config['base_uri'] = 'https://www.planviewer.nl';
        }

        parent::__construct($config);
    }

    /* APPLICATION */
    /* https://docs.planviewer.nl/mapsapi/server_calls/application.html# */

    public function ListLayerTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/layer_types');
        $batch = $this->json_decode($response);
        return $batch;
    }

    public function ListVectorSourceTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/vector_source_types');
        $batch = $this->json_decode($response);
        return $batch;
    }

    public function ListFeatureExportTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/feature_export_types');
        $batch = $this->json_decode($response);
        return $batch;
    }

    public function ListImageExportTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/image_export_types');
        $batch = $this->json_decode($response);
        return $batch;
    }

    public function ListFieldMappingTypes()
    {
        $response = $this->request('GET', '/maps_api/v2/server/mapping_types');
        $batch = $this->json_decode($response);
        return $batch;
    }

    public function uploadApplicatioSLD($options)
    {
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/sld/upload', $options);
        $batch = $this->json_decode($response);
        return $batch;
    }

    public function deleteApplicatioSLD()
    {
        $response = $this->request('DELETE', '/maps_api/v2/server/sld/delete');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function hasApplicatioSLD()
    {
        $response = $this->request('GET', '/maps_api/v2/server/sld');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getDefaultLegenda()
    {
        $response = $this->request('GET', '/maps_api/v2/server/legenda/default');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getWfsCapabilities($options)
    {
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wfs', $options);
        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getWmsCapabilities($options)
    {
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wms', $options);
        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getWmtsCapabilities($options)
    {
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wmts', $options);
        $batch = $this->json_decode($response);
        return $batch;
    }

    /* VIEWERS */
    /* https://docs.planviewer.nl/mapsapi/server_calls/viewers.html# */

    public function listViewers($options)
    {
        $this->isArray($options);

        $response = $this->request('GET', '/maps_api/v2/server/viewers', $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function createViewer($options)
    {
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers', $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getViewer($viewerId = false)
    {
        $this->isViewerId($viewerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function updateViewer($viewerId = false, $updateOptions = [])
    {
        $this->isViewerId($viewerId);
        $this->isArray($updateOptions);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId, $updateOptions);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function cloneViewer($viewerId = false)
    {
        $this->isViewerId($viewerId);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/clone');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function deleteViewer($viewerId = false)
    {
        $this->isViewerId($viewerId);

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/delete');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function snapshotViewer($viewerId = false, $options)
    {
        $this->isViewerId($viewerId);
        $this->isArray($options);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/snapshot', $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getViewerOutline($viewerId = false)
    {
        $this->isViewerId($viewerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/outline');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function setViewerOutline($viewerId = false, $options)
    {
        $this->isViewerId($viewerId);
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/outline', $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    /* LAYERS */
    /* https://docs.planviewer.nl/mapsapi/server_calls/layers.html# */

    public function listLayers($viewerId = false)
    {
        $this->isViewerId($viewerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function sortLayers($viewerId = false, $options)
    {
        $this->isViewerId($viewerId);
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/sort_layers', $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function createLayer($viewerId = false, $options)
    {
        $this->isViewerId($viewerId);
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers', $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function uploadShapefile($viewerId = false, $options)
    {
        $this->isViewerId($viewerId);
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/upload', $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function replaceShapefile($viewerId = false, $layerId, $options)
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/upload/'.$layerId.'/upload', $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getLayer($viewerId = false, $layerId = false)
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function updateLayer($viewerId = false, $layerId = false, $options)
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);
        $this->isArray($options);

        $response = $this->request('PATCH', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId, $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function deleteLayer($viewerId = false, $layerId = false)
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/delete');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getFeatureDataVectorLayer($viewerId = false, $layerId = false, $options = [])
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);
        $this->isArray($options);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/features', $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function uploadSldVectorLayer($viewerId = false, $layerId = false, $options = [])
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/sld/upload', $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function deleteSldVectorLayer($viewerId = false, $layerId = false)
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/sld/delete');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function hasSldVectorLayer($viewerId = false, $layerId = false)
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/sld');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getLegendVectorLayer($viewerId = false, $layerId = false)
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);

        $response = $this->request('GET', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/legenda');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function setPropertyVectorLayer($viewerId = false, $layerId = false, $options)
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/set_feature', $options);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getPropertiesVectorLayer($viewerId = false, $layerId = false)
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/get_properties');

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function deletePropertyVectorLayer($viewerId = false, $layerId = false, $featureId)
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);

        $response = $this->request('DELETE', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/delete_properties/'.$featureId);

        $batch = $this->json_decode($response);
        return $batch;
    }

    public function updatePropertyVectorLayer($viewerId = false, $layerId = false, $options)
    {
        $this->isViewerId($viewerId);
        $this->isLayerId($layerId);
        $this->isArray($options);

        $response = $this->request('POST', '/maps_api/v2/server/viewers/'.$viewerId.'/layers/'.$layerId.'/update_feature');

        $batch = $this->json_decode($response);
        return $batch;
    }


    protected function json_decode(Response $response, $assoc = false, $depth = 512, $options = 0)
    {

        $data = \json_decode((string) $response->getBody(), $assoc, $depth, $options);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(
                'json_decode error: ' . json_last_error_msg()
            );
        }

        return $data;
    }

    protected function isViewerId($viewerId)
    {
        if (!$viewerId) {
            throw new \Exception('No viewer ID has been given');
        }
    }

    protected function isLayerId($layerId)
    {
        if (!$layerId) {
            throw new \Exception('No layer ID has been given');
        }
        if (!is_int($layerId)) {
            throw new \Exception('Value given must be an integer');
        }
    }

    protected function isArray($array) {
        if (!is_array($array)) {
            throw new \Exception('Options must be an array');
        }
    }
}
