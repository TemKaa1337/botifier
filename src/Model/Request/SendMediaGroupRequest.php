<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\SendMediaGroupResponse;
use Temkaa\Botifier\Model\Shared\InputMediaAudio;
use Temkaa\Botifier\Model\Shared\InputMediaDocument;
use Temkaa\Botifier\Model\Shared\InputMediaPhoto;
use Temkaa\Botifier\Model\Shared\InputMediaVideo;
use Temkaa\Botifier\Model\Shared\ReplyParameters;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SendMediaGroupResponse>
 */
final readonly class SendMediaGroupRequest implements RequestInterface
{
    use ArrayFilterTrait;

    /**
     * @param InputMediaAudio[]|InputMediaDocument[]|InputMediaPhoto[]|InputMediaVideo[] $media
     */
    public function __construct(
        public int|string $chatId,
        public array $media,
        public ?string $businessConnectionId = null,
        public ?int $messageThreadId = null,
        public ?bool $disableNotification = null,
        public ?bool $protectContent = null,
        public ?bool $allowPaidBroadcast = null,
        public ?string $messageEffectId = null,
        public ?ReplyParameters $replyParameters = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SendMediaGroup;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'                => $this->chatId,
                'media'                  => array_map(
                    static fn (InputMediaAudio|InputMediaDocument|InputMediaPhoto|InputMediaVideo $type): array => $type->format(),
                    $this->media
                ),
                'business_connection_id' => $this->businessConnectionId,
                'message_thread_id'      => $this->messageThreadId,
                'disable_notification'   => $this->disableNotification,
                'protect_content'        => $this->protectContent,
                'allow_paid_broadcast'   => $this->allowPaidBroadcast,
                'message_effect_id'      => $this->messageEffectId,
                'reply_parameters'       => $this->replyParameters?->format() ?: null,
            ]
        );
    }
}
