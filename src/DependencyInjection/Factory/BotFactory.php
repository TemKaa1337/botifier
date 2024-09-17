<?php

declare(strict_types=1);

namespace Temkaa\Botifier\DependencyInjection\Factory;

use SensitiveParameter;
use Temkaa\Botifier\Model\Bot;
use Temkaa\SimpleContainer\Attribute\Bind\Parameter;

final readonly class BotFactory
{
    public static function create(
        #[Parameter('env(BOT_TOKEN)')]
        #[SensitiveParameter]
        string $token,
    ): Bot {
        return new Bot($token);
    }
}
