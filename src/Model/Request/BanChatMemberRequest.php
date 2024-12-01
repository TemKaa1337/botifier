<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\BanChatMemberResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<BanChatMemberResponse>
 */
final readonly class BanChatMemberRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int|string $chatId,
        public int $userId,
        public ?DateTimeImmutable $untilDate = null,
        public ?bool $revokeMessages = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::BanChatMember;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'         => $this->chatId,
                'user_id'         => $this->userId,
                'until_date'      => $this->untilDate?->setTimezone(new DateTimeZone('UTC'))?->getTimestamp() ?: null,
                'revoke_messages' => $this->revokeMessages,
            ]
        );
    }
}
