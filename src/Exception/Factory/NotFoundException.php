<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Exception\Factory;

use InvalidArgumentException;
use Temkaa\Botifier\Exception\BotifierExceptionInterface;

final class NotFoundException extends InvalidArgumentException implements BotifierExceptionInterface
{
    public function __construct(string $message)
    {
        parent::__construct(sprintf('Could not find content factory for message: "%s".', $message));
    }
}
