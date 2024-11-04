<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;

/**
 * @api
 *
 * @template TResponse of ResponseInterface
 */
interface RequestInterface
{
    public function getApiMethod(): ApiMethod;

    public function getHttpMethod(): HttpMethod;

    /**
     * @return array<string, mixed>
     */
    public function getParameters(): array;
}

