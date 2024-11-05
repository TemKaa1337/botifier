<?php

declare(strict_types=1);

namespace Temkaa\Botifier;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Temkaa\Botifier\Exception\FailedTelegramRequestException;
use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Handler\UnsupportedHandlerInterface;
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
     * @param TelegramClientInterface     $client
     * @param HandlerInterface[]          $handlers
     * @param SignalSubscriberInterface   $signalSubscriber
     * @param UnsupportedHandlerInterface $unsupportedHandler
     * @param LoggerInterface             $logger
     * @param float                       $pollingInterval
     */
    public function __construct(
        private TelegramClientInterface $client,
        array $handlers,
        private SignalSubscriberInterface $signalSubscriber,
        private UnsupportedHandlerInterface $unsupportedHandler,
        private LoggerInterface $logger = new NullLogger(),
        private float $pollingInterval = 3,
    ) {
        parent::__construct($handlers);
    }

    public function run(): void
    {
        while (!$this->signalSubscriber->terminate()) {
            $latestOffset ??= self::START_OFFSET;
            $response = $this->client->send(new GetUpdatesRequest(self::LIMIT, $latestOffset));

            if (!$response->success()) {
                // TODO: add some king of exit handler for user
                // TODO: add just a test now
                throw new FailedTelegramRequestException('Got unsuccessful telegram response.', $response);
            }

            /** @var Message[] $messages */
            $messages = $response->getResult();
            foreach ($messages as $message) {
                $handler = $this->getHandler($message) ?? $this->unsupportedHandler;
                $handler->handle($message);

                $latestOffset = (int) $message->getUpdateId() + 1;
            }

            usleep((int) $this->pollingInterval * 1_000_000);
        }

        $this->logger->info('Exiting from PollingRunner.');
    }
}
