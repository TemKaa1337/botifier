<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\User\Response;

use Temkaa\Botifier\Model\Shared\RequestInterface;

final readonly class Text implements RequestInterface
{
    public function __construct(
        private int $chatId,
        private string $text,
    ) {
    }

    public function toArray(): array
    {
        return ['chat_id' => $this->chatId, 'text' => $this->text];
    }
}
