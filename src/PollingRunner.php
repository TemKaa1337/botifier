<?php

declare(strict_types=1);

namespace Temkaa\Botifier;

// TODO: add builder?
use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Handler\UnsupportedHandlerInterface;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\Request\GetUpdatesRequest;
use Temkaa\Botifier\Model\Response\Message;
use Temkaa\Botifier\Service\TelegramClientInterface;
use Temkaa\Botifier\Subscriber\SignalSubscriberInterface;

/**
 * @api
 */
final readonly class PollingRunner extends AbstractRunner implements RunnerInterface
{
    /**
     * @param Bot                         $bot
     * @param TelegramClientInterface     $client
     * @param HandlerInterface[]          $handlers
     * @param float                       $pollingInterval
     * @param SignalSubscriberInterface   $signalSubscriber
     * @param UnsupportedHandlerInterface $unsupportedHandler
     */
    public function __construct(
        private Bot $bot,
        private TelegramClientInterface $client,
        array $handlers,
        private float $pollingInterval,
        private SignalSubscriberInterface $signalSubscriber,
        private UnsupportedHandlerInterface $unsupportedHandler,
    ) {
        parent::__construct($handlers);
    }

    public function run(): void
    {
        while (!$this->signalSubscriber->terminate()) {
            $updates = $this->client->send(new GetUpdatesRequest(), $this->bot);

            /** @var Message[] $messages */
            $messages = $updates->getResult();
            if (count($messages) > 0) {
                foreach ($messages as $message) {
                    if ($handler = $this->getHandler($message)) {
                        $handler->handle($message);

                        continue;
                    }

                    $this->unsupportedHandler->handle($message);
                }
            }

            usleep((int) $this->pollingInterval * 1_000_000);
        }
        // TODO: add log here
    }
}
