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

namespace Classes;

use GuzzleHttp\Psr7\Response;

interface apiInterface
{
    public function json_decode(Response $response, $assoc = false, $depth = 512, $options = 0);

    public function isViewerId($viewerId);

    public function isLayerId($layerId);

    public function isArray($array);
}