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

namespace Planviewer\Tools;

use GuzzleHttp\Psr7\Response;

class ApiHandler implements ApiInterface
{
    /**
     * @param Response $response
     *
     * @param bool $assoc
     * @param int  $depth
     * @param int  $options
     *
     * @return mixed
     */
    public function json_decode(Response $response, $assoc = false, $depth = 512, $options = 0)
    {

        $data = \json_decode((string) $response->getBody(), $assoc, $depth, $options);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(
                'json_decode error: ' . json_last_error_msg()
            );
        }

        return $data;
    }

    public function file(Response $response) {
     return $response->getBody()->getContents();
    }


    /**
     * @param $viewerId
     *
     * @throws \Exception
     */
    public function isViewerId($viewerId)
    {
        if (!$viewerId) {
            throw new \Exception('No viewer ID has been given');
        }
    }

    /**
     * @param $layerId
     *
     * @throws \Exception
     */
    public function isLayerId($layerId)
    {
        if (!$layerId) {
            throw new \Exception('No layer ID has been given');
        }
        if (!is_int($layerId)) {
            throw new \Exception('Value given must be an integer');
        }
    }

    /**
     * @param $array
     *
     * @throws \Exception
     */
    public function isArray($array) {
        if (!is_array($array)) {
            throw new \Exception('Options must be an array');
        }
    }

    public function validate(array $data, array $keys) {

        /** missing keys */
        $missing = array_diff($keys, array_keys($data));

        if(count($missing)) {
            return sprintf('missing data [%s]', implode(', ', $missing));
        }

        return null;
    }
}
