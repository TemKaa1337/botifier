<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Handler;

use Temkaa\Botifier\Model\Response\Nested\Update;

/**
 * @api
 */
interface UnsupportedHandlerInterface
{
    public function handle(Update $update): void;
}
