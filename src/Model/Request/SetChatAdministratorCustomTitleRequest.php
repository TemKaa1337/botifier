<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\SetChatAdministratorCustomTitleResponse;

/**
 * @api
 *
 * @implements RequestInterface<SetChatAdministratorCustomTitleResponse>
 */
final readonly class SetChatAdministratorCustomTitleRequest implements RequestInterface
{
    public function __construct(
        public int|string $chatId,
        public int $userId,
        public string $customTitle
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetChatAdministratorCustomTitle;
    }

    public function getData(): array
    {
        return [
            'chat_id'      => $this->chatId,
            'user_id'      => $this->userId,
            'custom_title' => $this->customTitle,
        ];
    }
}
