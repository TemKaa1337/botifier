<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\CopyMessageResponse;
use Temkaa\Botifier\Model\Shared\ForceReply;
use Temkaa\Botifier\Model\Shared\InlineKeyboardMarkup;
use Temkaa\Botifier\Model\Shared\MessageEntity;
use Temkaa\Botifier\Model\Shared\ReplyKeyboardMarkup;
use Temkaa\Botifier\Model\Shared\ReplyKeyboardRemove;
use Temkaa\Botifier\Model\Shared\ReplyParameters;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<CopyMessageResponse>
 */
final readonly class CopyMessageRequest implements RequestInterface
{
    use ArrayFilterTrait;

    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        public int|string $chatId,
        public int|string $fromChatId,
        public int $messageId,
        public ?int $messageThreadId = null,
        public ?string $caption = null,
        public ?string $parseMode = null,
        public ?array $captionEntities = null,
        public ?bool $showCaptionAboveMedia = null,
        public ?bool $disableNotification = null,
        public ?bool $protectContent = null,
        public ?bool $allowPaidBroadcast = null,
        public ?ReplyParameters $replyParameters = null,
        public ForceReply|InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|null $replyMarkup = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::CopyMessage;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'                  => $this->chatId,
                'from_chat_id'             => $this->fromChatId,
                'message_id'               => $this->messageId,
                'message_thread_id'        => $this->messageThreadId,
                'caption'                  => $this->caption,
                'parse_mode'               => $this->parseMode,
                'caption_entities'         => $this->captionEntities === null
                    ? null
                    : array_map(
                        static fn (MessageEntity $type): array => $type->format(),
                        $this->captionEntities
                    ),
                'show_caption_above_media' => $this->showCaptionAboveMedia,
                'disable_notification'     => $this->disableNotification,
                'protect_content'          => $this->protectContent,
                'allow_paid_broadcast'     => $this->allowPaidBroadcast,
                'reply_parameters'         => $this->replyParameters?->format() ?: null,
                'reply_markup'             => $this->replyMarkup?->format() ?: null,
            ]
        );
    }
}
