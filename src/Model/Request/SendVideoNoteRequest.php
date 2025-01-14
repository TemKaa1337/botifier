<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SendVideoNoteResponse;
use Temkaa\Botifier\Model\Shared\ForceReply;
use Temkaa\Botifier\Model\Shared\InlineKeyboardMarkup;
use Temkaa\Botifier\Model\Shared\InputFile;
use Temkaa\Botifier\Model\Shared\ReplyKeyboardMarkup;
use Temkaa\Botifier\Model\Shared\ReplyKeyboardRemove;
use Temkaa\Botifier\Model\Shared\ReplyParameters;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SendVideoNoteResponse>
 */
final readonly class SendVideoNoteRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int|string $chatId,
        public InputFile|string $videoNote,
        public ?string $businessConnectionId = null,
        public ?int $messageThreadId = null,
        public ?int $duration = null,
        public ?int $length = null,
        public InputFile|string|null $thumbnail = null,
        public ?bool $disableNotification = null,
        public ?bool $protectContent = null,
        public ?bool $allowPaidBroadcast = null,
        public ?string $messageEffectId = null,
        public ?ReplyParameters $replyParameters = null,
        public ForceReply|InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|null $replyMarkup = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SendVideoNote;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'                => $this->chatId,
                'video_note'             => is_object($this->videoNote) ? $this->videoNote->format() : $this->videoNote,
                'business_connection_id' => $this->businessConnectionId,
                'message_thread_id'      => $this->messageThreadId,
                'duration'               => $this->duration,
                'length'                 => $this->length,
                'thumbnail'              => is_object($this->thumbnail) ? $this->thumbnail->format() : $this->thumbnail,
                'disable_notification'   => $this->disableNotification,
                'protect_content'        => $this->protectContent,
                'allow_paid_broadcast'   => $this->allowPaidBroadcast,
                'message_effect_id'      => $this->messageEffectId,
                'reply_parameters'       => $this->replyParameters?->format() ?: null,
                'reply_markup'           => $this->replyMarkup?->format() ?: null,
            ]
        );
    }
}
