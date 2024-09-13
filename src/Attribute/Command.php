<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class Command
{
    public function __construct(
        public string $signature,
    ) {
    }
}
