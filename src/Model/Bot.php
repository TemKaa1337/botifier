<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model;

use SensitiveParameter;
use Temkaa\Botifier\DependencyInjection\Factory\BotFactory;
use Temkaa\SimpleContainer\Attribute\Factory;

#[Factory(id: BotFactory::class, method: 'create')]
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
