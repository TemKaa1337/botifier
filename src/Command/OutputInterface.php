<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command;

/**
 * @internal
 */
interface OutputInterface
{
    public function write(string ...$messages): void;

    public function writeln(string ...$messages): void;
}
