<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\ReplaceStickerInSetResponse;
use Temkaa\Botifier\Model\Shared\InputSticker;

/**
 * @api
 *
 * @implements RequestInterface<ReplaceStickerInSetResponse>
 */
final readonly class ReplaceStickerInSetRequest implements RequestInterface
{
    public function __construct(
        public int $userId,
        public string $name,
        public string $oldSticker,
        public InputSticker $sticker
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::ReplaceStickerInSet;
    }

    public function getData(): array
    {
        return [
            'user_id'     => $this->userId,
            'name'        => $this->name,
            'old_sticker' => $this->oldSticker,
            'sticker'     => $this->sticker->format(),
        ];
    }
}
