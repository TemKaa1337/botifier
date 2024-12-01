<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\SetChatTitleResponse;

/**
 * @api
 *
 * @implements RequestInterface<SetChatTitleResponse>
 */
final readonly class SetChatTitleRequest implements RequestInterface
{
    public function __construct(
        public int|string $chatId,
        public string $title
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetChatTitle;
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'title'   => $this->title,
        ];
    }
}
