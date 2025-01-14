<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetStickerEmojiListResponse;

/**
 * @api
 *
 * @implements RequestInterface<SetStickerEmojiListResponse>
 */
final readonly class SetStickerEmojiListRequest implements RequestInterface
{
    /**
     * @param string[] $emojiList
     */
    public function __construct(
        public string $sticker,
        public array $emojiList
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetStickerEmojiList;
    }

    public function getData(): array
    {
        return [
            'sticker'    => $this->sticker,
            'emoji_list' => $this->emojiList,
        ];
    }
}
