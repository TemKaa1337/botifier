<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Exception\Config;

use InvalidArgumentException;
use Temkaa\Botifier\Exception\BotifierExceptionInterface;

final class InvalidConfigurationException extends InvalidArgumentException implements BotifierExceptionInterface
{
}
