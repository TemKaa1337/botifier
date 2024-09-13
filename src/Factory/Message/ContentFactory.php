<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Exception\Message\Factory\NotFoundException;
use Temkaa\Botifier\Model\Input\ContentInterface;
use Temkaa\SimpleContainer\Attribute\Bind\Tagged;

final class ContentFactory
{
    public function __construct(
        #[Tagged(tag: 'content_factory')]
        private readonly iterable $factories,
    ) {
    }

    public function create(string $message): ContentInterface
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($message)) {
                return $factory->create($message);
            }
        }

        throw new NotFoundException($message);
    }
}
