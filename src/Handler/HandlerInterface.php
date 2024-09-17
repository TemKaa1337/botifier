<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Handler;

// TODO: change supports method? mb we dont have signature here to check if signature is supported
use Temkaa\Botifier\Model\Input\Message;

interface HandlerInterface
{
    public function handle(Message $message): void;

    public function supports(Message $message): bool;
}
