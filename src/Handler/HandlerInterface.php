<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Handler;

use Temkaa\Botifier\Model\Shared\Message;

interface HandlerInterface
{
    public function handle(Message $message): void;

    public function supports(Message $message): bool;
}
