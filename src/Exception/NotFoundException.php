<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Exception;

use InvalidArgumentException;

final class NotFoundException extends InvalidArgumentException implements BotifierExceptionInterface
{
}
