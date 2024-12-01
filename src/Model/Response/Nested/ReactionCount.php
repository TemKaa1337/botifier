<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Nested;

use Temkaa\Botifier\Model\Shared\ReactionTypeCustomEmoji;
use Temkaa\Botifier\Model\Shared\ReactionTypeEmoji;
use Temkaa\Botifier\Model\Shared\ReactionTypePaid;

final readonly class ReactionCount
{
    public function __construct(
        public ReactionTypeEmoji|ReactionTypeCustomEmoji|ReactionTypePaid $type,
        public int $totalCount
    ) {}
}
