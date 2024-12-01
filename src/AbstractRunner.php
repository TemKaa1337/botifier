<?php

declare(strict_types=1);

namespace Temkaa\Botifier;

use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Model\Response\Nested\Update;

/**
 * @internal
 */
abstract readonly class AbstractRunner
{
    /**
     * @param HandlerInterface[] $handlers
     */
    public function __construct(
        private array $handlers,
    ) {
    }

    protected function getHandler(Update $update): ?HandlerInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($update)) {
                return $handler;
            }
        }

        return null;
    }
}
