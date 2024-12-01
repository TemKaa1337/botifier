<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\CreateChatSubscriptionInviteLinkResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<CreateChatSubscriptionInviteLinkResponse>
 */
final readonly class CreateChatSubscriptionInviteLinkRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int|string $chatId,
        public int $subscriptionPeriod,
        public int $subscriptionPrice,
        public ?string $name = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::CreateChatSubscriptionInviteLink;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'             => $this->chatId,
                'subscription_period' => $this->subscriptionPeriod,
                'subscription_price'  => $this->subscriptionPrice,
                'name'                => $this->name,
            ]
        );
    }
}
