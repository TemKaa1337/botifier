<?php

declare(strict_types=1);

namespace Temkaa\Botifier;

use JsonException;
use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Handler\UnsupportedHandlerInterface;
use Temkaa\Botifier\Model\Shared\Message;
use Temkaa\Botifier\Provider\Webhook\MessageProvider;

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
        $response = $this->messageProvider->provide();

        /** @var Message $message */
        $message = $response->getResult();

        if ($handler = $this->getHandler($message)) {
            $handler->handle($message);

            return;
        }

        $this->unsupportedHandler->handle($message);
    }
}
