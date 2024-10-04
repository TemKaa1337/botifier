<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use JsonException;
use Temkaa\Botifier\Exception\NotFoundException;
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
        private array $factories,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function create(array $message): ContentInterface
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($message)) {
                return $factory->create($message);
            }
        }

        throw new NotFoundException(
            sprintf(
                'Could not find content factory for message "%s".',
                json_encode($message, JSON_THROW_ON_ERROR),
            ),
        );
    }
}
