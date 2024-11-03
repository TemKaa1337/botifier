<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\GetUpdatesResponse;

/**
 * @api
 * @implements RequestInterface<GetUpdatesResponse>
 */
final readonly class GetUpdatesRequest implements RequestInterface
{
    public function __construct(
        private int $limit,
        private int $offset,
    ) {
    }

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
        return ['limit' => $this->limit, 'offset' => $this->offset];
    }
}
