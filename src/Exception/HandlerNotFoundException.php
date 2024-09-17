<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Exception;

use InvalidArgumentException;

final class HandlerNotFoundException extends InvalidArgumentException implements BotifierExceptionInterface
{
    public function __construct(string $message)
    {
        parent::__construct(sprintf('Could not find handler for message "%s".', $message));
    }
}
