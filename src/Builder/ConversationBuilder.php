<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Builder;

use Temkaa\Botifier\Enum\Conversation\UnprocessedStrategy;
use Temkaa\Botifier\Exception\Config\InvalidConversationConfigurationException;
use Temkaa\Botifier\Model\Config\Conversation;
use Temkaa\Botifier\Model\Config\Conversation\State;
use Temkaa\Botifier\Processor\ConversationFallbackProcessorInterface;
use Temkaa\Botifier\Processor\StatelessProcessorInterface;
use function sprintf;

/**
 * @api
 *
 * @psalm-suppress MissingConstructor
 */
final class ConversationBuilder
{
    private string $endState;

    /**
     * @var class-string<StatelessProcessorInterface>
     */
    private string $entrypoint;

    /**
     * @var list<class-string<ConversationFallbackProcessorInterface>>
     */
    private array $fallbacks = [];

    private string $name;

    private string $startState;

    /**
     * @var list<State>
     */
    private array $states = [];

    private UnprocessedStrategy $unprocessedStrategy = UnprocessedStrategy::LeaveUnprocessed;

    /**
     * @param class-string<ConversationFallbackProcessorInterface> $processor
     */
    public function addFallback(string $processor): self
    {
        $instance = clone $this;
        $fallbacks = $instance->fallbacks;
        $fallbacks[] = $processor;

        $instance->fallbacks = $fallbacks;

        return $instance;
    }

    public function addState(State $state): self
    {
        $instance = clone $this;
        $states = $instance->states;
        $states[] = $state;

        $instance->states = $states;

        return $instance;
    }

    public function build(): Conversation
    {
        // TODO: validate empty states + add test on empty states
        $this->validateInitialized(property: 'name');
        $this->validateInitialized(property: 'startState');
        $this->validateInitialized(property: 'endState');
        $this->validateInitialized(property: 'entrypoint');

        return new Conversation(
            $this->name,
            $this->entrypoint,
            $this->startState,
            $this->endState,
            $this->states,
            $this->fallbacks,
            $this->unprocessedStrategy,
        );
    }

    public function endState(string $state): self
    {
        $instance = clone $this;
        $instance->endState = $state;

        return $instance;
    }

    /**
     * @param class-string<StatelessProcessorInterface> $processor
     */
    public function entrypoint(string $processor): self
    {
        $instance = clone $this;
        $instance->entrypoint = $processor;

        return $instance;
    }

    /**
     * @param non-empty-string $name
     */
    public function name(string $name): self
    {
        $instance = clone $this;
        $instance->name = $name;

        return $instance;
    }

    public function startState(string $state): self
    {
        $instance = clone $this;
        $instance->startState = $state;

        return $instance;
    }

    public function unprocessedStrategy(UnprocessedStrategy $strategy): self
    {
        $instance = clone $this;
        $instance->unprocessedStrategy = $strategy;

        return $instance;
    }

    private function validateInitialized(string $property): void
    {
        if (!isset($this->{$property})) {
            throw new InvalidConversationConfigurationException(
                sprintf('Property "%s" for Conversation must be filled.', $property),
            );
        }
    }
}
