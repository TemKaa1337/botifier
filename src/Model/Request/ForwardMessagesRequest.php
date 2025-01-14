<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\ForwardMessagesResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<ForwardMessagesResponse>
 */
final readonly class ForwardMessagesRequest implements RequestInterface
{
    use ArrayFilterTrait;

    /**
     * @param int[] $messageIds
     */
    public function __construct(
        public int|string $chatId,
        public int|string $fromChatId,
        public array $messageIds,
        public ?int $messageThreadId = null,
        public ?bool $disableNotification = null,
        public ?bool $protectContent = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::ForwardMessages;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'              => $this->chatId,
                'from_chat_id'         => $this->fromChatId,
                'message_ids'          => $this->messageIds,
                'message_thread_id'    => $this->messageThreadId,
                'disable_notification' => $this->disableNotification,
                'protect_content'      => $this->protectContent,
            ]
        );
    }
}
