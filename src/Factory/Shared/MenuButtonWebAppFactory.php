<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Model\Shared\MenuButtonWebApp;

final readonly class MenuButtonWebAppFactory
{
    public function __construct(private WebAppInfoFactory $webAppInfoFactory) {}

    public function create(array $message): MenuButtonWebApp
    {
        return new MenuButtonWebApp(
            $message['type'],
            $message['text'],
            $this->webAppInfoFactory->create($message['web_app'])
        );
    }
}
