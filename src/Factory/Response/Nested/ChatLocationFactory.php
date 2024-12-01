<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\ChatLocation;

final readonly class ChatLocationFactory
{
    public function __construct(private LocationFactory $locationFactory) {}

    public function create(array $message): ChatLocation
    {
        return new ChatLocation(
            $this->locationFactory->create($message['location']),
            $message['address']
        );
    }
}
