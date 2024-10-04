<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model;

use SensitiveParameter;

/**
 * @api
 */
final readonly class Bot
{
    public function __construct(
        #[SensitiveParameter]
        private string $token,
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
