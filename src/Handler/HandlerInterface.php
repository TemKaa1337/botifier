<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Handler;

interface HandlerInterface
{
    public function handle(string $token): void;
}
