<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Model\Response\Nested\InaccessibleMessage;

final readonly class InaccessibleMessageFactory
{
    public function __construct(private ChatFactory $chatFactory) {}

    public function create(array $message): InaccessibleMessage
    {
        return new InaccessibleMessage(
            $this->chatFactory->create($message['chat']),
            $message['message_id'],
            (new DateTimeImmutable())->setTimestamp($message['date'])->setTimezone(new DateTimeZone('UTC'))
        );
    }
}
