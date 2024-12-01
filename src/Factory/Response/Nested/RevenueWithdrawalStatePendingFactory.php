<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\RevenueWithdrawalStatePending;

final readonly class RevenueWithdrawalStatePendingFactory
{
    public function create(array $message): RevenueWithdrawalStatePending
    {
        return new RevenueWithdrawalStatePending(
            $message['type']
        );
    }
}
