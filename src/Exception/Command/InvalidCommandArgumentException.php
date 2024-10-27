<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Exception\Command;

use InvalidArgumentException;
use Temkaa\Botifier\Exception\BotifierExceptionInterface;

final class InvalidCommandArgumentException extends InvalidArgumentException implements BotifierExceptionInterface
{
}
