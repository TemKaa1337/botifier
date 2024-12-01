<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

final readonly class ReactionTypeCustomEmoji
{
    public function __construct(
        public string $type,
        public string $customEmojiId
    ) {}

    public function format(): array
    {
        return [
            'type'            => $this->type,
            'custom_emoji_id' => $this->customEmojiId,
        ];
    }
}
