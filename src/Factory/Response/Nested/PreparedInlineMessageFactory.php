<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Model\Response\Nested\PreparedInlineMessage;

final readonly class PreparedInlineMessageFactory
{
    public function create(array $message): PreparedInlineMessage
    {
        return new PreparedInlineMessage(
            $message['id'],
            (new DateTimeImmutable())->setTimestamp($message['expiration_date'])->setTimezone(new DateTimeZone('UTC'))
        );
    }
}
