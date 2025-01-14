<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

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
    /**
     * @return array<string, mixed>
     */
    public function getData(): array;

    public function getHttpMethod(): HttpMethod;

    public function getApiMethod(): ApiMethod;
}
