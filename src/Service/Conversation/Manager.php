<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service\Conversation;

use InvalidArgumentException;
use Temkaa\Botifier\Model\Config\Conversation;
use Temkaa\Botifier\Model\CurrentConversation;
use Temkaa\Botifier\Model\CurrentConversation\Context;
use Temkaa\Botifier\Processor\ConversationFallbackProcessorInterface;
use Temkaa\Botifier\Processor\ConversationProcessorInterface;
use Temkaa\Botifier\Processor\StatelessProcessorInterface;
use function sprintf;

final readonly class Manager
{
    /**
     * @param list<Conversation> $conversations
     */
    public function __construct(
        private array $conversations,
        private StorageInterface $storage,
    ) {
        // TODO: throw exceptions if storageInterface methods return false
    }

    public function get(int|string $chatId, int $userId): ?CurrentConversation
    {
        return $this->storage->get($chatId, $userId);
    }

    /**
     * @return list<class-string<ConversationFallbackProcessorInterface>>
     */
    public function getFallbackProcessors(CurrentConversation $currentConversation): array
    {
        foreach ($this->conversations as $conversation) {
            if ($conversation->name === $currentConversation->name) {
                return $conversation->fallbacks;
            }
        }

        throw new InvalidArgumentException(
            sprintf(
                'Cannot get fallback processors for conversation: "%s" in source mapping.',
                $currentConversation->name,
            ),
        );
    }

    /**
     * @return list<class-string<ConversationProcessorInterface>>
     */
    public function getStateProcessors(string $conversationName, string $stateName): array
    {
        $currentConversation = $this->getConversation($conversationName);

        $currentState = null;
        foreach ($currentConversation->states as $state) {
            if ($state->name === $stateName) {
                $currentState = $state;
                break;
            }
        }

        if (!$currentState) {
            throw new InvalidArgumentException(
                sprintf(
                    'Cannot get state processor for conversation: "%s", state: "%s" in source mapping.',
                    $conversationName,
                    $stateName,
                ),
            );
        }

        return $currentState->processors;
    }

    public function save(CurrentConversation $currentConversation): void
    {
        $configConversation = $this->getConversation($currentConversation->name);
        if ($configConversation->endState === $currentConversation->state) {
            $this->storage->delete($currentConversation->chatId, $currentConversation->userId);
        } else {
            $this->storage->set($currentConversation);
        }
    }

    public function startIfEntrypoint(StatelessProcessorInterface $processor, int|string $chatId, int $userId): void
    {
        foreach ($this->conversations as $conversation) {
            if ($conversation->entrypoint !== $processor::class) {
                continue;
            }

            $this->storage->set(
                new CurrentConversation(
                    $chatId,
                    $userId,
                    $conversation->name,
                    $conversation->startState,
                    new Context(),
                    $conversation->unprocessedStrategy
                ),
            );

            return;
        }
    }

    private function getConversation(string $conversationName): Conversation
    {
        foreach ($this->conversations as $conversation) {
            if ($conversation->name === $conversationName) {
                return $conversation;
            }
        }

        throw new InvalidArgumentException(
            sprintf('Cannot get state processor for conversation: "%s" in source mapping.', $conversationName),
        );
    }
}
