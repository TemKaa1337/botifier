<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Model\Response\Nested\VideoChatScheduled;

final readonly class VideoChatScheduledFactory
{
    public function create(array $message): VideoChatScheduled
    {
        return new VideoChatScheduled(
            (new DateTimeImmutable())->setTimestamp($message['start_date'])->setTimezone(new DateTimeZone('UTC'))
        );
    }
}
