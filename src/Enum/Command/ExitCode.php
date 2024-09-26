<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Enum\Command;

enum ExitCode: int
{
    case Failure = 1;
    case Success = 0;
}
