<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Handler;

use Temkaa\Botifier\Model\Shared\Message;

interface UnsupportedHandlerInterface
{
    public function handle(Message $message): void;
}
