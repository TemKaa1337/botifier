<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Message\Content;

use Temkaa\Botifier\Enum\Message\Content\Type;
use Temkaa\Botifier\Model\Response\Message\ContentInterface;

/**
 * @api
 */
final readonly class Command implements ContentInterface
{
    public function __construct(
        private string $signature,
        private ?string $parameters,
        private Type $type,
    ) {
    }

    public function getParameters(): ?string
    {
        return $this->parameters;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function getType(): Type
    {
        return $this->type;
    }
}
