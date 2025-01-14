<?php

declare(strict_types=1);

namespace Temkaa\Botifier;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Temkaa\Botifier\Exception\FailedTelegramRequestException;
use Temkaa\Botifier\Model\Request\GetUpdatesRequest;
use Temkaa\Botifier\Processor\UpdateProcessor;
use Temkaa\Botifier\Service\Telegram\ClientInterface;
use Temkaa\Botifier\Subscriber\SignalSubscriberInterface;
use function usleep;

/**
 * @api
 */
final readonly class PollingRunner implements RunnerInterface
{
    public const float DEFAULT_POLLING_INTERVAL = 3;
    private const int LIMIT = 10;
    private const int START_OFFSET = 0;

    /**
     * @param list<string> $allowedUpdates
     */
    public function __construct(
        private array $allowedUpdates,
        private ClientInterface $client,
        private float $pollingInterval,
        private SignalSubscriberInterface $signalSubscriber,
        private UpdateProcessor $updateProcessor,
        private LoggerInterface $logger = new NullLogger(),
    ) {
    }

    public function run(): void
    {
        while (!$this->signalSubscriber->terminate()) {
            $latestOffset ??= self::START_OFFSET;
            $response = $this->client->send(
                new GetUpdatesRequest($latestOffset, self::LIMIT, allowedUpdates: $this->allowedUpdates),
            );

            if (!$response->ok || $response->result === null) {
                // TODO: add some king of exit handler for user
                // TODO: add just a test now
                // TODO: maybe name it something like 'strategy' or so
                throw new FailedTelegramRequestException('Got unsuccessful telegram response.', $response);
            }

            foreach ($response->result as $update) {
                $this->updateProcessor->process($update);

                $latestOffset = $update->updateId + 1;
            }

            usleep((int) $this->pollingInterval * 1_000_000);
        }

        // TODO: change log type everywhere?
        $this->logger->info('Exiting from PollingRunner.');
    }
}
