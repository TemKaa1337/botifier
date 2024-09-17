<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Runner;

use Temkaa\Botifier\Exception\HandlerNotFoundException;
use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Model\Input\Message;

abstract readonly class BaseRunner
{
    /**
     * @var HandlerInterface[] $handlers
     */
    public function __construct(
        private array $handlers,
    ) {
    }

    protected function getHandler(Message $message): HandlerInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($message)) {
                return $handler;
            }
        }

        throw new HandlerNotFoundException($message);
    }
}
