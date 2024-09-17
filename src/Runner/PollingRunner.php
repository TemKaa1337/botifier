<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Runner;

// TODO: add builder?
use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Exception\HandlerNotFoundException;
use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Serializer\Serializer;
use Temkaa\Botifier\Http\Client;
use Temkaa\SimpleContainer\Attribute\Bind\InstanceOfIterator;
use Temkaa\SimpleContainer\Attribute\Bind\Parameter;

final readonly class PollingRunner extends BaseRunner implements RunnerInterface
{
    public function __construct(
        private Bot $bot,
        /**
         * @var HandlerInterface[] $handlers
         */
        #[InstanceOfIterator(HandlerInterface::class)]
        array $handlers,
        private Serializer $serializer,
        private Client $client,
        #[Parameter('env(BOT_POLLING_INTERVAL)')]
        private int $pollingInterval = 5,
    ) {
        parent::__construct($handlers);
    }

    public function run(): void
    {
        // TODO: add signals listeners
        while (true) {
            if ($updates = $this->client->send(Action::GetUpdates, $this->bot)) {
                $messages = $this->serializer->deserialize($updates->getBody()->getContents());

                foreach ($messages as $message) {
                    $handler = $this->getHandler($message);

                    $handler->handle($message);
                }
            }

            sleep($this->pollingInterval);
        }
    }
}
