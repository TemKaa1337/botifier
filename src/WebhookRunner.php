<?php

declare(strict_types=1);

namespace Temkaa\Botifier;

use JsonException;
use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Handler\UnsupportedHandlerInterface;
use Temkaa\Botifier\Model\Response\Message;
use Temkaa\Botifier\Provider\Webhook\MessageProvider;

/**
 * @api
 */
final readonly class WebhookRunner extends AbstractRunner implements RunnerInterface
{
    /**
     * @param HandlerInterface[] $handlers
     */
    public function __construct(
        array $handlers,
        private MessageProvider $messageProvider,
        private UnsupportedHandlerInterface $unsupportedHandler,
    ) {
        parent::__construct($handlers);
    }

    /**
     * @throws JsonException
     */
    public function run(): void
    {
        /** @var Message $message */
        $message = $this->messageProvider->provide();

        $handler = $this->getHandler($message) ?? $this->unsupportedHandler;
        $handler->handle($message);
    }
}
