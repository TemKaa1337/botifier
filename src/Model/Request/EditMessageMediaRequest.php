<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\EditMessageMediaResponse;
use Temkaa\Botifier\Model\Shared\InlineKeyboardMarkup;
use Temkaa\Botifier\Model\Shared\InputMediaAnimation;
use Temkaa\Botifier\Model\Shared\InputMediaAudio;
use Temkaa\Botifier\Model\Shared\InputMediaDocument;
use Temkaa\Botifier\Model\Shared\InputMediaPhoto;
use Temkaa\Botifier\Model\Shared\InputMediaVideo;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<EditMessageMediaResponse>
 */
final readonly class EditMessageMediaRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public InputMediaAnimation|InputMediaDocument|InputMediaAudio|InputMediaPhoto|InputMediaVideo $media,
        public ?string $businessConnectionId = null,
        public int|string|null $chatId = null,
        public ?int $messageId = null,
        public ?string $inlineMessageId = null,
        public ?InlineKeyboardMarkup $replyMarkup = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::EditMessageMedia;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'media'                  => $this->media->format(),
                'business_connection_id' => $this->businessConnectionId,
                'chat_id'                => $this->chatId,
                'message_id'             => $this->messageId,
                'inline_message_id'      => $this->inlineMessageId,
                'reply_markup'           => $this->replyMarkup?->format() ?: null,
            ]
        );
    }
}
