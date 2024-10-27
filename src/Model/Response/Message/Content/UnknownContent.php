<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Message\Content;

use Temkaa\Botifier\Enum\Message\Content\Type;
use Temkaa\Botifier\Model\Response\Message\ContentInterface;

/**
 * @api
 */
final readonly class UnknownContent implements ContentInterface
{
    public function __construct(
        private array $message,
        private string $key,
        private Type $type,
    ) {
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getMessage(): array
    {
        return $this->message;
    }

    public function getType(): Type
    {
        return $this->type;
    }
}
