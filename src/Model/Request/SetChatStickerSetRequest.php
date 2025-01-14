<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetChatStickerSetResponse;

/**
 * @api
 *
 * @implements RequestInterface<SetChatStickerSetResponse>
 */
final readonly class SetChatStickerSetRequest implements RequestInterface
{
    public function __construct(
        public int|string $chatId,
        public string $stickerSetName
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetChatStickerSet;
    }

    public function getData(): array
    {
        return [
            'chat_id'          => $this->chatId,
            'sticker_set_name' => $this->stickerSetName,
        ];
    }
}
