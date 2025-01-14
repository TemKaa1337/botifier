<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response;

use Temkaa\Botifier\Model\Response\Nested\ResponseParameters;
use Temkaa\Botifier\Model\ResponseInterface;
use Temkaa\Botifier\Model\Shared\MenuButtonCommands;
use Temkaa\Botifier\Model\Shared\MenuButtonDefault;
use Temkaa\Botifier\Model\Shared\MenuButtonWebApp;

final readonly class GetChatMenuButtonResponse implements ResponseInterface
{
    public function __construct(
        public bool $ok,
        public MenuButtonCommands|MenuButtonWebApp|MenuButtonDefault|null $result = null,
        public ?string $description = null,
        public ?int $errorCode = null,
        public ?ResponseParameters $parameters = null
    ) {}
}
