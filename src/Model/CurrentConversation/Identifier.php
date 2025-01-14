<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\CurrentConversation;

final readonly class Identifier
{
    public function __construct(
        public int|string $chatId,
        public int $userId,
    ) {
    }
}
