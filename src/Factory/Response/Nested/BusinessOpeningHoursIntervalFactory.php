<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\BusinessOpeningHoursInterval;

final readonly class BusinessOpeningHoursIntervalFactory
{
    public function create(array $message): BusinessOpeningHoursInterval
    {
        return new BusinessOpeningHoursInterval(
            $message['opening_minute'],
            $message['closing_minute']
        );
    }
}
