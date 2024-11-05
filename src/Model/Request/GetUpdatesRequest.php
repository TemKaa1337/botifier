<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Enum\UpdateType;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\GetUpdatesResponse;

/**
 * @api
 * @implements RequestInterface<GetUpdatesResponse>
 */
final readonly class GetUpdatesRequest implements RequestInterface
{
    /**
     * @param int          $limit
     * @param int          $offset
     * @param UpdateType[] $updateTypes
     */
    public function __construct(
        private int $limit,
        private int $offset,
        private array $updateTypes = [],
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
        // TODO: add test on allowed_updates from polling runner
        // TODO: add test on allowed_updates when setting webhook
        return [
            'limit'           => $this->limit,
            'offset'          => $this->offset,
            'allowed_updates' => array_map(
                static fn (UpdateType $updateType): string => $updateType->value,
                $this->updateTypes,
            ),
        ];
    }
}
