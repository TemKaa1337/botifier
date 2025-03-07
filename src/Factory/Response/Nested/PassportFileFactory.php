<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Model\Response\Nested\PassportFile;

final readonly class PassportFileFactory
{
    public function create(array $message): PassportFile
    {
        return new PassportFile(
            $message['file_id'],
            $message['file_unique_id'],
            $message['file_size'],
            (new DateTimeImmutable())->setTimestamp($message['file_date'])->setTimezone(new DateTimeZone('UTC'))
        );
    }
}
