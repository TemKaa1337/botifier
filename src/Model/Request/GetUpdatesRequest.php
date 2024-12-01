<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\GetUpdatesResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<GetUpdatesResponse>
 */
final readonly class GetUpdatesRequest implements RequestInterface
{
    use ArrayFilterTrait;

    /**
     * @param string[]|null $allowedUpdates
     */
    public function __construct(
        public ?int $offset = null,
        public ?int $limit = null,
        public ?int $timeout = null,
        public ?array $allowedUpdates = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetUpdates;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'offset'          => $this->offset,
                'limit'           => $this->limit,
                'timeout'         => $this->timeout,
                'allowed_updates' => $this->allowedUpdates,
            ]
        );
    }
}
