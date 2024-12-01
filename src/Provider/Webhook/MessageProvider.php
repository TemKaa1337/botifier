<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider\Webhook;

use JsonException;
use Temkaa\Botifier\Factory\Response\Nested\UpdateFactory;
use Temkaa\Botifier\Model\Response\Nested\Update;

/**
 * @internal
 */
final readonly class MessageProvider
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
