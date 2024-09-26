<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Api\Request;

use Temkaa\Botifier\Model\Shared\RequestInterface;

final readonly class DeleteDescription implements RequestInterface
{
    public function __construct(
        private string $language,
    ) {
    }

    public function toArray(): array
    {
        return ['language_code' => $this->language];
    }
}
