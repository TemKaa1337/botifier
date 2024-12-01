<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Handler;

use Temkaa\Botifier\Model\Response\Nested\Update;

/**
 * @api
 */
interface HandlerInterface
{
    public function handle(Update $update): void;

    public function supports(Update $update): bool;
}
