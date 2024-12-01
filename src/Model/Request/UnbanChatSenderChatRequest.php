<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\UnbanChatSenderChatResponse;

/**
 * @api
 *
 * @implements RequestInterface<UnbanChatSenderChatResponse>
 */
final readonly class UnbanChatSenderChatRequest implements RequestInterface
{
    public function __construct(
        public int|string $chatId,
        public int $senderChatId
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::UnbanChatSenderChat;
    }

    public function getData(): array
    {
        return [
            'chat_id'        => $this->chatId,
            'sender_chat_id' => $this->senderChatId,
        ];
    }
}
