<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\RefundStarPaymentResponse;

/**
 * @api
 *
 * @implements RequestInterface<RefundStarPaymentResponse>
 */
final readonly class RefundStarPaymentRequest implements RequestInterface
{
    public function __construct(
        public int $userId,
        public string $telegramPaymentChargeId
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::RefundStarPayment;
    }

    public function getData(): array
    {
        return [
            'user_id'                    => $this->userId,
            'telegram_payment_charge_id' => $this->telegramPaymentChargeId,
        ];
    }
}
