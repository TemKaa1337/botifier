<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;

/**
 * @api
 */
interface RequestInterface
{
    public function getApiMethod(): ApiMethod;

    public function getHttpMethod(): HttpMethod;

    public function getParameters(): array;
}

