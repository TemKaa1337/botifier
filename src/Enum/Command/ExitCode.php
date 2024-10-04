<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Enum\Command;

/**
 * @internal
 */
enum ExitCode: int
{
    case Failure = 1;
    case Success = 0;
}
