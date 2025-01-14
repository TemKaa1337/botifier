<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Processor;

use Temkaa\Botifier\Model\Response\Nested\Update;

// TODO: delete
/**
 * If none of stateless processors support current update, class which implements this interface will be called
 */
interface StatelessFallbackProcessorInterface
{
    public function process(Update $update): void;
}
