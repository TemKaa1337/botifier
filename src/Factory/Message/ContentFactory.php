<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Factory\Message\Content\UnknownContentFactory;
use Temkaa\Botifier\Model\Response\Message\ContentInterface;

/**
 * @internal
 */
final readonly class ContentFactory
{
    /**
     * @param list<ContentFactoryInterface> $factories
     */
    public function __construct(
        private UnknownContentFactory $defaultFactory,
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

        return $this->defaultFactory->create($message);
    }
}
