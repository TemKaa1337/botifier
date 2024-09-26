<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

interface RequestInterface
{
    public function toArray(): array;
}
