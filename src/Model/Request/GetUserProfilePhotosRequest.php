<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\GetUserProfilePhotosResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<GetUserProfilePhotosResponse>
 */
final readonly class GetUserProfilePhotosRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int $userId,
        public ?int $offset = null,
        public ?int $limit = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetUserProfilePhotos;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'user_id' => $this->userId,
                'offset'  => $this->offset,
                'limit'   => $this->limit,
            ]
        );
    }
}
