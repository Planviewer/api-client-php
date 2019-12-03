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

    public function listViewers(array $options = []) {

        if(!isset($options['query'])) {
            $options['query'] = [
                'limit' => '10',
                'offset' => '0',
            ];
        }

        if(!isset($options['query']['limit'])) {
            $options['query']['limit'] = 10;
        }

        if(!isset($options['query']['offset'])) {
            $options['query']['offset'] = 0;
        }

        $response = $this->request('GET', '/maps_api/v2/server/viewers', $options);

        $batch = $this->json_decode($response)->viewers;
        return $batch;
    }

    public function json_decode(Response $response, $assoc = false, $depth = 512, $options = 0) {

        $data = \json_decode((string) $response->getBody(), $assoc, $depth, $options);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(
                'json_decode error: ' . json_last_error_msg()
            );
        }

        return $data;
    }
}
