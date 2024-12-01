<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\RefundedPayment;

final readonly class RefundedPaymentFactory
{
    public function create(array $message): RefundedPayment
    {
        return new RefundedPayment(
            $message['currency'],
            $message['total_amount'],
            $message['invoice_payload'],
            $message['telegram_payment_charge_id'],
            $message['provider_payment_charge_id'] ?? null
        );
    }
}
