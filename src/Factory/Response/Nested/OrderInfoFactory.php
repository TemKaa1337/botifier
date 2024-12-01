<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\OrderInfo;

final readonly class OrderInfoFactory
{
    public function __construct(private ShippingAddressFactory $shippingAddressFactory) {}

    public function create(array $message): OrderInfo
    {
        return new OrderInfo(
            $message['name'] ?? null,
            $message['phone_number'] ?? null,
            $message['email'] ?? null,
            isset($message['shipping_address']) ? $this->shippingAddressFactory->create($message['shipping_address']) : null
        );
    }
}
