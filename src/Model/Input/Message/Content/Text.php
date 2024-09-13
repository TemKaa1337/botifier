<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Input\Message\Content;

use Temkaa\Botifier\Enum\Message\Content\Type;
use Temkaa\Botifier\Model\Input\ContentInterface;

final class Text implements ContentInterface
{
    private string $text;

    private Type $type;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): self
    {
        $this->type = $type;

        return $this;
    }
}
