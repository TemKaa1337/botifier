<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Model\Shared\ReactionTypeCustomEmoji;

final readonly class ReactionTypeCustomEmojiFactory
{
    public function create(array $message): ReactionTypeCustomEmoji
    {
        return new ReactionTypeCustomEmoji(
            $message['type'],
            $message['custom_emoji_id']
        );
    }
}
