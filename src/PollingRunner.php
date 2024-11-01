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
    private const int LIMIT = 10;
    private const int START_OFFSET = 0;

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
        private SignalSubscriberInterface $signalSubscriber,
        private UnsupportedHandlerInterface $unsupportedHandler,
        private float $pollingInterval = 3,
    ) {
        parent::__construct($handlers);
    }

    public function run(): void
    {
        while (!$this->signalSubscriber->terminate()) {
            $latestOffset ??= self::START_OFFSET;
            $updates = $this->client->send(new GetUpdatesRequest(self::LIMIT, $latestOffset), $this->bot);

            /** @var Message[] $messages */
            $messages = $updates->getResult();
            foreach ($messages as $message) {
                $handler = $this->getHandler($message) ?? $this->unsupportedHandler;
                $handler->handle($message);

                $latestOffset = (int) $message->getUpdateId() + 1;
            }

            usleep((int) $this->pollingInterval * 1_000_000);
        }
        // TODO: add log here
    }
}
