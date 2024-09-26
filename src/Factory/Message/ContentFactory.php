<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Model\Shared\Message\ContentInterface;

final readonly class ContentFactory
{
    /**
     * @param list<ContentFactoryInterface> $factories
     */
    public function __construct(
        private array $factories,
    ) {
    }

    public function create(array $message): ContentInterface
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($message)) {
                return $factory->create($message);
            }
        }

        // TODO: throw exception
    }
}
