<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\ProximityAlertTriggered;

final readonly class ProximityAlertTriggeredFactory
{
    public function __construct(private UserFactory $userFactory) {}

    public function create(array $message): ProximityAlertTriggered
    {
        return new ProximityAlertTriggered(
            $this->userFactory->create($message['traveler']),
            $this->userFactory->create($message['watcher']),
            $message['distance']
        );
    }
}
