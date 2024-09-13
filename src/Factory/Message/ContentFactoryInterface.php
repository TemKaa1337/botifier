<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Model\Input\ContentInterface;
use Temkaa\SimpleContainer\Attribute\Tag;

#[Tag(name: 'content_factory')]
interface ContentFactoryInterface
{
    public function create(array $message): ContentInterface;

    public function supports(array $message): bool;
}
