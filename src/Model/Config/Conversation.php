<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Config;

use Temkaa\Botifier\Enum\Conversation\UnprocessedStrategy;
use Temkaa\Botifier\Exception\Config\InvalidConversationConfigurationException;
use Temkaa\Botifier\Model\Config\Conversation\State;
use Temkaa\Botifier\Processor\ConversationFallbackProcessorInterface;
use Temkaa\Botifier\Processor\ConversationProcessorInterface;
use Temkaa\Botifier\Processor\StatelessProcessorInterface;
use function class_implements;
use function in_array;
use function sprintf;

// TODO: add timeout?
// TODO: add state check when current state processor returns invalid state which does not exist in conversation
final readonly class Conversation
{
    /**
     * @param class-string<StatelessProcessorInterface>                  $entrypoint
     * @param list<State>                                                $states
     * @param list<class-string<ConversationFallbackProcessorInterface>> $fallbacks
     */
    public function __construct(
        public string $name,
        public string $entrypoint,
        public string $startState,
        public string $endState,
        public array $states,
        public array $fallbacks,
        public UnprocessedStrategy $unprocessedStrategy,
    ) {
        $this->validateEntrypoint();
        $this->validateStartState();
        $this->validateFallbacks();
    }

    private function validateEntrypoint(): void
    {
        if (!in_array(StatelessProcessorInterface::class, class_implements($this->entrypoint), true)) {
            throw new InvalidConversationConfigurationException(
                sprintf(
                    'Specified entrypoint "%s" for conversation "%s" must implement "%s" interface.',
                    $this->entrypoint,
                    $this->name,
                    ConversationProcessorInterface::class,
                ),
            );
        }
    }

    private function validateFallbacks(): void
    {
        foreach ($this->fallbacks as $fallback) {
            if (!in_array(ConversationFallbackProcessorInterface::class, class_implements($fallback), true)) {
                throw new InvalidConversationConfigurationException(
                    sprintf(
                        'Specified fallback "%s" for conversation "%s" must implement "%s" interface.',
                        $fallback,
                        $this->name,
                        ConversationProcessorInterface::class,
                    ),
                );
            }
        }
    }

    private function validateStartState(): void
    {
        $found = false;
        foreach ($this->states as $state) {
            if ($state->name === $this->startState) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw new InvalidConversationConfigurationException(
                sprintf(
                    'Specified start state "%s" for conversation "%s" is missing in state list.',
                    $this->startState,
                    $this->name,
                ),
            );
        }
    }
}
