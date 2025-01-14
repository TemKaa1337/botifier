<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\UnpinAllForumTopicMessagesResponse;

/**
 * @api
 *
 * @implements RequestInterface<UnpinAllForumTopicMessagesResponse>
 */
final readonly class UnpinAllForumTopicMessagesRequest implements RequestInterface
{
    public function __construct(
        public int|string $chatId,
        public int $messageThreadId
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::UnpinAllForumTopicMessages;
    }

    public function getData(): array
    {
        return [
            'chat_id'           => $this->chatId,
            'message_thread_id' => $this->messageThreadId,
        ];
    }
}
