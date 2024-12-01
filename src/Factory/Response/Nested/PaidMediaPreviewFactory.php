<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\PaidMediaPreview;

final readonly class PaidMediaPreviewFactory
{
    public function create(array $message): PaidMediaPreview
    {
        return new PaidMediaPreview(
            $message['type'],
            $message['width'] ?? null,
            $message['height'] ?? null,
            $message['duration'] ?? null
        );
    }
}
