<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\RevokeChatInviteLinkResponse;

/**
 * @api
 *
 * @implements RequestInterface<RevokeChatInviteLinkResponse>
 */
final readonly class RevokeChatInviteLinkRequest implements RequestInterface
{
    public function __construct(
        public int|string $chatId,
        public string $inviteLink
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::RevokeChatInviteLink;
    }

    public function getData(): array
    {
        return [
            'chat_id'     => $this->chatId,
            'invite_link' => $this->inviteLink,
        ];
    }
}
