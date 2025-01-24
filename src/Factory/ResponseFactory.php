<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory;

use InvalidArgumentException;
use JsonException;
use Temkaa\Botifier\Enum\ApiMethod;

use Temkaa\Botifier\Model\ResponseInterface;
use function json_decode;
use function sprintf;

final readonly class ResponseFactory
{
    /**
     * @param list<FactoryInterface> $factories
     */
    public function __construct(
        private array $factories,
    ) {}

    /**
     * @throws JsonException
     */
    public function create(ApiMethod $apiMethod, string $message): ResponseInterface
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($apiMethod)) {
                /** @var array<string, mixed> $decoded */
                $decoded = json_decode($message, true, 512, JSON_THROW_ON_ERROR);

                return $factory->create($decoded);
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
