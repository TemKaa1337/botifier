<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\EditChatInviteLinkResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<EditChatInviteLinkResponse>
 */
final readonly class EditChatInviteLinkRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int|string $chatId,
        public string $inviteLink,
        public ?string $name = null,
        public ?DateTimeImmutable $expireDate = null,
        public ?int $memberLimit = null,
        public ?bool $createsJoinRequest = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::EditChatInviteLink;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'              => $this->chatId,
                'invite_link'          => $this->inviteLink,
                'name'                 => $this->name,
                'expire_date'          => $this->expireDate?->setTimezone(new DateTimeZone('UTC'))?->getTimestamp() ?: null,
                'member_limit'         => $this->memberLimit,
                'creates_join_request' => $this->createsJoinRequest,
            ]
        );
    }
}
