<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Processor;

use Temkaa\Botifier\Model\Response\Nested\Update;

interface UnsupportedStatelessProcessorInterface
{
    public function process(Update $update): void;
}
