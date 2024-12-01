<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Model\Response\Nested\RevenueWithdrawalStateSucceeded;

final readonly class RevenueWithdrawalStateSucceededFactory
{
    public function create(array $message): RevenueWithdrawalStateSucceeded
    {
        return new RevenueWithdrawalStateSucceeded(
            $message['type'],
            (new DateTimeImmutable())->setTimestamp($message['date'])->setTimezone(new DateTimeZone('UTC')),
            $message['url']
        );
    }
}
