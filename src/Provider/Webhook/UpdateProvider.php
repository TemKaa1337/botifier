<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider\Webhook;

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

        return $this->updateFactory->create(json_decode($message, true, 512, JSON_THROW_ON_ERROR));
    }
}
