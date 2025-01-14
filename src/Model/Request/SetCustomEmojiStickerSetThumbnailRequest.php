<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetCustomEmojiStickerSetThumbnailResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetCustomEmojiStickerSetThumbnailResponse>
 */
final readonly class SetCustomEmojiStickerSetThumbnailRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public string $name,
        public ?string $customEmojiId = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetCustomEmojiStickerSetThumbnail;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'name'            => $this->name,
                'custom_emoji_id' => $this->customEmojiId,
            ]
        );
    }
}
