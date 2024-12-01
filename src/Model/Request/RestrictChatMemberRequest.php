<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\RestrictChatMemberResponse;
use Temkaa\Botifier\Model\Shared\ChatPermissions;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<RestrictChatMemberResponse>
 */
final readonly class RestrictChatMemberRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int|string $chatId,
        public int $userId,
        public ChatPermissions $permissions,
        public ?bool $useIndependentChatPermissions = null,
        public ?DateTimeImmutable $untilDate = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::RestrictChatMember;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'                          => $this->chatId,
                'user_id'                          => $this->userId,
                'permissions'                      => $this->permissions->format(),
                'use_independent_chat_permissions' => $this->useIndependentChatPermissions,
                'until_date'                       => $this->untilDate?->setTimezone(new DateTimeZone('UTC'))?->getTimestamp() ?: null,
            ]
        );
    }
}
