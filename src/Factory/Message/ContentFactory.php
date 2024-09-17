<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Exception\Factory\NotFoundException;
use Temkaa\Botifier\Model\Input\Message\ContentInterface;
use Temkaa\SimpleContainer\Attribute\Bind\InstanceOfIterator;

final readonly class ContentFactory
{
    public function __construct(
        #[InstanceOfIterator(ContentFactoryInterface::class)]
        private iterable $factories,
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
