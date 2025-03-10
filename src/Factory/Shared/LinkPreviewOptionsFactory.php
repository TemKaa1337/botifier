<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Model\Shared\LinkPreviewOptions;

final readonly class LinkPreviewOptionsFactory
{
    public function create(array $message): LinkPreviewOptions
    {
        return new LinkPreviewOptions(
            $message['is_disabled'] ?? null,
            $message['url'] ?? null,
            $message['prefer_small_media'] ?? null,
            $message['prefer_large_media'] ?? null,
            $message['show_above_text'] ?? null
        );
    }
}
