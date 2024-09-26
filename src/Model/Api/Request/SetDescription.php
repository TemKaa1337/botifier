<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Api\Request;

use Temkaa\Botifier\Model\Shared\RequestInterface;

final readonly class SetDescription implements RequestInterface
{
    public function __construct(
        private string $description,
        private string $language,
    ) {
    }

    public function toArray(): array
    {
        return ['description' => $this->description, 'language_code' => $this->language];
    }
}
