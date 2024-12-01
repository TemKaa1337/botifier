<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\PreCheckoutQuery;

final readonly class PreCheckoutQueryFactory
{
    public function __construct(
        private UserFactory $userFactory,
        private OrderInfoFactory $orderInfoFactory
    ) {}

    public function create(array $message): PreCheckoutQuery
    {
        return new PreCheckoutQuery(
            $message['id'],
            $this->userFactory->create($message['from']),
            $message['currency'],
            $message['total_amount'],
            $message['invoice_payload'],
            $message['shipping_option_id'] ?? null,
            isset($message['order_info']) ? $this->orderInfoFactory->create($message['order_info']) : null
        );
    }
}
