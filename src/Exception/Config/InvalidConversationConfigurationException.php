<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Exception\Config;

use InvalidArgumentException;
use Temkaa\Botifier\Exception\BotifierExceptionInterface;

final class InvalidConversationConfigurationException extends InvalidArgumentException implements BotifierExceptionInterface
{
}
