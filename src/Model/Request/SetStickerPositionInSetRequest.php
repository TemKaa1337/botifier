<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetStickerPositionInSetResponse;

/**
 * @api
 *
 * @implements RequestInterface<SetStickerPositionInSetResponse>
 */
final readonly class SetStickerPositionInSetRequest implements RequestInterface
{
    public function __construct(
        public string $sticker,
        public int $position
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetStickerPositionInSet;
    }

    public function getData(): array
    {
        return [
            'sticker'  => $this->sticker,
            'position' => $this->position,
        ];
    }
}
