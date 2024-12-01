<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\BackgroundTypeWallpaper;

final readonly class BackgroundTypeWallpaperFactory
{
    public function __construct(private DocumentFactory $documentFactory) {}

    public function create(array $message): BackgroundTypeWallpaper
    {
        return new BackgroundTypeWallpaper(
            $message['type'],
            $this->documentFactory->create($message['document']),
            $message['dark_theme_dimming'],
            $message['is_blurred'] ?? null,
            $message['is_moving'] ?? null
        );
    }
}
