<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Model\Shared\ReactionTypeEmoji;

final readonly class ReactionTypeEmojiFactory
{
    public function create(array $message): ReactionTypeEmoji
    {
        return new ReactionTypeEmoji(
            $message['type'],
            $message['emoji']
        );
    }
}
