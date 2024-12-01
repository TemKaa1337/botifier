<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\GetStarTransactionsResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<GetStarTransactionsResponse>
 */
final readonly class GetStarTransactionsRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public ?int $offset = null,
        public ?int $limit = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetStarTransactions;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'offset' => $this->offset,
                'limit'  => $this->limit,
            ]
        );
    }
}
