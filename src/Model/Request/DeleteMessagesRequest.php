<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\DeleteMessagesResponse;

/**
 * @api
 *
 * @implements RequestInterface<DeleteMessagesResponse>
 */
final readonly class DeleteMessagesRequest implements RequestInterface
{
    /**
     * @param int[] $messageIds
     */
    public function __construct(
        public int|string $chatId,
        public array $messageIds
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::DeleteMessages;
    }

    public function getData(): array
    {
        return [
            'chat_id'     => $this->chatId,
            'message_ids' => $this->messageIds,
        ];
    }
}
