<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model;

interface ResponseInterface
{
    public function raw(): array;

    public function success(): bool;
}
