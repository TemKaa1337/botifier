<?php

declare(strict_types=1);

namespace Temkaa\Botifier;

use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Model\Shared\Message;

abstract readonly class AbstractRunner
{
    /**
     * @var HandlerInterface[] $handlers
     */
    public function __construct(
        private array $handlers,
    ) {
    }

    protected function getHandler(Message $message): ?HandlerInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($message)) {
                return $handler;
            }
        }

        return null;
    }
}
