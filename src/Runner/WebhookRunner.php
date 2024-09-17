<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Runner;

use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Provider\Webhook\MessageProvider;
use Temkaa\SimpleContainer\Attribute\Bind\InstanceOfIterator;

final readonly class WebhookRunner extends BaseRunner implements RunnerInterface
{
    public function __construct(
        private Bot $bot,
        /**
         * @var HandlerInterface[] $handlers
         */
        #[InstanceOfIterator(HandlerInterface::class)]
        array $handlers,
        private MessageProvider $messageProvider,
    ) {
        parent::__construct($handlers);
    }

    public function run(): void
    {
        $message = $this->messageProvider->provide();

        $handler = $this->getHandler($message);

        $handler->handle($message);
    }
}
