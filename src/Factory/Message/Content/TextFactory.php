<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message\Content;

use Temkaa\Botifier\Enum\Message\Content\Type;
use Temkaa\Botifier\Factory\Message\ContentFactoryInterface;
use Temkaa\Botifier\Model\Input\Message\Content\Text;
use Temkaa\Botifier\Model\Input\Message\ContentInterface;

final readonly class TextFactory implements ContentFactoryInterface
{
    public function create(array $message): ContentInterface
    {
        return new Text($message['text'], Type::Text);
    }

    public function supports(array $message): bool
    {
        return isset($message['text']);
    }
}
