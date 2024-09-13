<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message\Content;

use Temkaa\Botifier\Enum\Message\Content\Type;
use Temkaa\Botifier\Factory\Message\ContentFactoryInterface;
use Temkaa\Botifier\Model\Input\ContentInterface;
use Temkaa\Botifier\Model\Input\Message\Content\Text;

final class TextFactory implements ContentFactoryInterface
{
    public function create(array $message): ContentInterface
    {
        return (new Text())
            ->setText($message['text'])
            ->setType(Type::Text);
    }

    public function supports(array $message): bool
    {
        return isset($message['text']);
    }
}
