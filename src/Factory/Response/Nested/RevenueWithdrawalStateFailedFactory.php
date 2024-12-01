<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\RevenueWithdrawalStateFailed;

final readonly class RevenueWithdrawalStateFailedFactory
{
    public function create(array $message): RevenueWithdrawalStateFailed
    {
        return new RevenueWithdrawalStateFailed(
            $message['type']
        );
    }
}
