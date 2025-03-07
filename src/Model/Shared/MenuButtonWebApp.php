<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

final readonly class MenuButtonWebApp
{
    public function __construct(
        public string $type,
        public string $text,
        public WebAppInfo $webApp
    ) {}

    public function format(): array
    {
        return [
            'type'    => $this->type,
            'text'    => $this->text,
            'web_app' => $this->webApp->format(),
        ];
    }
}
