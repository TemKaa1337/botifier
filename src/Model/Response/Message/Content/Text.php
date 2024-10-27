<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Message\Content;

use Temkaa\Botifier\Enum\Message\Content\Type;
use Temkaa\Botifier\Model\Response\Message\ContentInterface;

/**
 * @api
 */
final readonly class Text implements ContentInterface
{
    public function __construct(
        private string $text,
        private Type $type,
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getType(): Type
    {
        return $this->type;
    }
}
