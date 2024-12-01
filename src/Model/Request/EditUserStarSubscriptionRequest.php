<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\EditUserStarSubscriptionResponse;

/**
 * @api
 *
 * @implements RequestInterface<EditUserStarSubscriptionResponse>
 */
final readonly class EditUserStarSubscriptionRequest implements RequestInterface
{
    public function __construct(
        public int $userId,
        public string $telegramPaymentChargeId,
        public bool $isCanceled
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::EditUserStarSubscription;
    }

    public function getData(): array
    {
        return [
            'user_id'                    => $this->userId,
            'telegram_payment_charge_id' => $this->telegramPaymentChargeId,
            'is_canceled'                => $this->isCanceled,
        ];
    }
}
