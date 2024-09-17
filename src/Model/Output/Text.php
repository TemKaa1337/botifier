<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Output;

final readonly class Text
{
    public function __construct(
        private string $text,
    ) {
    }
}
