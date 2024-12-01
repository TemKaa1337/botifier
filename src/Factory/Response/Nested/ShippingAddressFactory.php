<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\ShippingAddress;

final readonly class ShippingAddressFactory
{
    public function create(array $message): ShippingAddress
    {
        return new ShippingAddress(
            $message['country_code'],
            $message['state'],
            $message['city'],
            $message['street_line1'],
            $message['street_line2'],
            $message['post_code']
        );
    }
}
