<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

// TODO: move somewhere
// TODO: add test on this
final readonly class WebApp
{
    public function __construct(
        private string $url,
    ) {
    }

    public function format(): array
    {
        return ['url' => $this->url];
    }
}
