<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command;

use Temkaa\Botifier\Model\Input\Message;
use Temkaa\SimpleContainer\Attribute\Tag;

#[Tag(name: 'command')]
interface CommandInterface
{
    public function handle(Message $message): void;
}
