<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\AddStickerToSetResponse;
use Temkaa\Botifier\Model\Shared\InputSticker;

/**
 * @api
 *
 * @implements RequestInterface<AddStickerToSetResponse>
 */
final readonly class AddStickerToSetRequest implements RequestInterface
{
    public function __construct(
        public int $userId,
        public string $name,
        public InputSticker $sticker
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::AddStickerToSet;
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
            'name'    => $this->name,
            'sticker' => $this->sticker->format(),
        ];
    }
}
