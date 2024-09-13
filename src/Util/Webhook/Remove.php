<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Util\Webhook;

final readonly class Remove implements RunnableInterface
{
    public function __construct(
        private string $token,
    ) {
    }

    public function run(): void
    {
        // TODO: Implement run() method.
    }
}
