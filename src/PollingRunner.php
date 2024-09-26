<?php

declare(strict_types=1);

namespace Temkaa\Botifier;

// TODO: add builder?
use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Handler\UnsupportedHandlerInterface;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\Shared\Message;
use Temkaa\Botifier\Service\TelegramClient;
use Temkaa\Botifier\Subscriber\SignalSubscriber;

final readonly class PollingRunner extends AbstractRunner implements RunnerInterface
{
    public function __construct(
        private Bot $bot,
        private TelegramClient $client,
        array $handlers,
        private int $pollingInterval,
        private UnsupportedHandlerInterface $unsupportedHandler,
        private SignalSubscriber $signalSubscriber,
    ) {
        parent::__construct($handlers);
    }

    public function run(): void
    {
        while (!$this->signalSubscriber->isAnyTriggered()) {
            $updates = $this->client->send(Action::GetUpdates, $this->bot);

            if ($messages = $updates->getResult()) {
                /** @var list<Message> $messages */
                foreach ($messages as $message) {
                    if ($handler = $this->getHandler($message)) {
                        $handler->handle($message);

                        continue;
                    }

                    $this->unsupportedHandler->handle($message);
                }
            }

            sleep($this->pollingInterval);
        }

        // TODO: add log here
    }
}
