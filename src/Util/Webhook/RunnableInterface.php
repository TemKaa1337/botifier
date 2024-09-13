<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Util\Webhook;

interface RunnableInterface
{
    public function run(): void;
}
