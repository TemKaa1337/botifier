<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Nested;

use DateTimeImmutable;

final readonly class MessageOriginChat
{
    public function __construct(
        public string $type,
        public DateTimeImmutable $date,
        public Chat $senderChat,
        public ?string $authorSignature = null
    ) {}
}
