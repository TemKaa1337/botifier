<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\GetChatAdministratorsResponse;

/**
 * @api
 *
 * @implements RequestInterface<GetChatAdministratorsResponse>
 */
final readonly class GetChatAdministratorsRequest implements RequestInterface
{
    public function __construct(public int|string $chatId) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetChatAdministrators;
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
        ];
    }
}
