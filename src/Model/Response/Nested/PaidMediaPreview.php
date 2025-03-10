<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Nested;

final readonly class PaidMediaPreview
{
    public function __construct(
        public string $type,
        public ?int $width = null,
        public ?int $height = null,
        public ?int $duration = null
    ) {}
}
