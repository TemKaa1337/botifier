<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;

/**
 * @api
 */
final readonly class GetUpdatesRequest implements RequestInterface
{
    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetUpdates;
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Get;
    }

    public function getParameters(): array
    {
        return [];
    }
}
