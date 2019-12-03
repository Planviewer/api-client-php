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

    public function uploadApplicatioSLD($filename = false, $content = false)
    {
        if(!$filename || !$content) {
            throw new \Exception('Not all fields are present');
        }
        if(!$this->is_base64_encoded($content)) {
            throw new \Exception('Content is not base64 encoded');
        }

        $response = $this->request('POST', '/maps_api/v2/server/sld/upload', [
            'filename' => $filename,
            'content' => $content,
        ]);
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

    public function getWfsCapabilities($url = false)
    {
        if (!$url) {
            throw new \Exception('No Url given');
        }

        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wfs', [
            'url' => $url,
        ]);
        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getWmsCapabilities($url = false)
    {
        if (!$url) {
            throw new \Exception('No Url given');
        }

        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wms', [
            'url' => $url,
        ]);
        $batch = $this->json_decode($response);
        return $batch;
    }

    public function getWmtsCapabilities($url = false)
    {
        if (!$url) {
            throw new \Exception('No Url given');
        }

        $response = $this->request('POST', '/maps_api/v2/server/capabilities/wmts', [
            'url' => $url,
        ]);
        $batch = $this->json_decode($response);
        return $batch;
    }


    public function listViewers($limit = 10, $offset = 0)
    {

        $options = [
            'limit' => $limit,
            'offset' => $offset,
        ];

        $response = $this->request('GET', '/maps_api/v2/server/viewers', $options);

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

    protected function is_base64_encoded($data)
    {
        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
