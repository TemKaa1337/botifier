<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command;

use Temkaa\Botifier\Enum\Command\Argument;

/**
 * @internal
 */
interface InputInterface
{
    public function getArgument(Argument $name): string;

    public function hasArgument(Argument $name): bool;

    public function raw(): array;
}
