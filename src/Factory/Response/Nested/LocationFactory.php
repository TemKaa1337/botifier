<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\Location;

final readonly class LocationFactory
{
    public function create(array $message): Location
    {
        return new Location(
            $message['latitude'],
            $message['longitude'],
            $message['horizontal_accuracy'] ?? null,
            $message['live_period'] ?? null,
            $message['heading'] ?? null,
            $message['proximity_alert_radius'] ?? null
        );
    }
}
