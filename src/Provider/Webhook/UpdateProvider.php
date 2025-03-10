<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider\Webhook;

use InvalidArgumentException;
use JsonException;
use Temkaa\Botifier\Factory\Response\Nested\UpdateFactory;
use Temkaa\Botifier\Model\Response\Nested\Update;
use function file_get_contents;
use function json_decode;

/**
 * @internal
 */
final readonly class UpdateProvider implements UpdateProviderInterface
{
    public function __construct(
        private UpdateFactory $updateFactory,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function provide(): Update
    {
        $message = file_get_contents('php://input');

        if ($message === false) {
            throw new InvalidArgumentException('Cannot read webhook update update from "php://input".');
        }

        /** @var array<string, mixed> $decoded */
        $decoded = json_decode($message, true, 512, JSON_THROW_ON_ERROR);

        return $this->updateFactory->create($decoded);
    }
}
