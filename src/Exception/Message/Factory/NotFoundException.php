<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Exception\Message\Factory;

use LogicException;

final class NotFoundException extends LogicException
{
    public function __construct(string $message)
    {
        parent::__construct(message: "Could not find factory for message : \"$message\".");
    }
}
