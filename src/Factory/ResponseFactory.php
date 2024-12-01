<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory;

use InvalidArgumentException;
use JsonException;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Interface\Response\FactoryInterface;
use Temkaa\Botifier\Interface\ResponseInterface;

final readonly class ResponseFactory
{
    /**
     * @param list<FactoryInterface> $factories
     */
    public function __construct(
        private array $factories,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function create(ApiMethod $apiMethod, string $message): ResponseInterface
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($apiMethod)) {
                return $factory->create(json_decode($message, true, 512, JSON_THROW_ON_ERROR));
            }
        }

        throw new InvalidArgumentException(
            sprintf(
                'Could not find factory class for message: "%s".',
                $message,
            ),
        );
    }
}
