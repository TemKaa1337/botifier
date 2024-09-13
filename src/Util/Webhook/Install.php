<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Util\Webhook;

final readonly class Install implements RunnableInterface
{
    public function __construct(
        private string $token,
        private string $url,
        private ?string $certificatePath = null,
    ) {
    }

    public function run(): void
    {
        // TODO: Implement run() method.
    }
}
