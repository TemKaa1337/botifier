<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\ShippingQuery;

final readonly class ShippingQueryFactory
{
    public function __construct(
        private UserFactory $userFactory,
        private ShippingAddressFactory $shippingAddressFactory
    ) {}

    public function create(array $message): ShippingQuery
    {
        return new ShippingQuery(
            $message['id'],
            $this->userFactory->create($message['from']),
            $message['invoice_payload'],
            $this->shippingAddressFactory->create($message['shipping_address'])
        );
    }
}
