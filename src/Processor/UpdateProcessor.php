<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Processor;

use InvalidArgumentException;
use Temkaa\Botifier\Enum\Conversation\UnprocessedStrategy;
use Temkaa\Botifier\Model\CurrentConversation;
use Temkaa\Botifier\Model\CurrentConversation\Identifier;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Provider\Conversation\IdentifierProviderInterface;
use Temkaa\Botifier\Provider\Conversation\SearchIdentifierProviderInterface;
use Temkaa\Botifier\Provider\Conversation\StartIdentifierProviderInterface;
use Temkaa\Botifier\Service\Conversation\Manager;
use function implode;
use function sprintf;

final readonly class UpdateProcessor
{
    /**
     * @param array<class-string<ConversationFallbackProcessorInterface>, ConversationFallbackProcessorInterface> $statefulFallbackProcessors
     * @param array<class-string<ConversationProcessorInterface>, ConversationProcessorInterface>                 $statefulProcessors
     * @param list<StatelessProcessorInterface>                                                                   $statelessProcessors
     */
    public function __construct(
        private Manager $manager,
        private SearchIdentifierProviderInterface $searchIdentifierProvider,
        private StartIdentifierProviderInterface $startIdentifierProvider,
        private array $statefulFallbackProcessors,
        private array $statefulProcessors,
        private array $statelessProcessors,
        private UnsupportedConversationProcessorInterface $unsupportedStatefulProcessor,
        private UnsupportedStatelessProcessorInterface $unsupportedStatelessProcessor,
    ) {
    }

    public function process(Update $update): void
    {
        $conversationIdentifier = $this->searchIdentifierProvider->provide($update);

        if (
            !$conversationIdentifier
            || !$currentConversation = $this->manager->get(
                $conversationIdentifier->chatId,
                $conversationIdentifier->userId,
            )
        ) {
            $this->processNonConversation($update);

            return;
        }

        $this->processConversation($update, $currentConversation);
    }

    /**
     * @param list<class-string<ConversationFallbackProcessorInterface>> $fallbackProcessorClasses
     *
     * @return list<ConversationFallbackProcessorInterface>
     */
    private function getStatefulFallbackProcessors(
        array $fallbackProcessorClasses,
        CurrentConversation $currentConversation,
    ): array {
        $fallbackProcessors = [];
        foreach ($fallbackProcessorClasses as $fallbackProcessorClass) {
            if (!$fallbackProcessor = $this->statefulFallbackProcessors[$fallbackProcessorClass] ?? null) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Fallback for conversation "%s" with state "%s" is configured to be processed by "[%s]" processors, but '
                        .'processor "%s" was not found. Maybe you forgot to add it to container?',
                        $currentConversation->name,
                        $currentConversation->state,
                        implode(', ', $fallbackProcessorClasses),
                        $fallbackProcessorClass,
                    ),
                );
            }

            $fallbackProcessors[] = $fallbackProcessor;
        }

        return $fallbackProcessors;
    }

    /**
     * @param list<class-string<ConversationProcessorInterface>> $processorClasses
     *
     * @return list<ConversationProcessorInterface>
     */
    private function getStatefulProcessors(array $processorClasses, CurrentConversation $currentConversation): array
    {
        $processors = [];
        foreach ($processorClasses as $processorClass) {
            if (!$processor = $this->statefulProcessors[$processorClass] ?? null) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Conversation "%s" with state "%s" is configured to be processed by "[%s]" processors, but '
                        .'processor "%s" was not found. Maybe you forgot to add it to container?',
                        $currentConversation->name,
                        $currentConversation->state,
                        implode(', ', $processorClasses),
                        $processorClass,
                    ),
                );
            }

            $processors[] = $processor;
        }

        return $processors;
    }

    private function processConversation(Update $update, CurrentConversation $currentConversation): void
    {
        $processorClasses = $this->manager->getStateProcessors(
            $currentConversation->name,
            $currentConversation->state,
        );
        $processors = $this->getStatefulProcessors($processorClasses, $currentConversation);

        foreach ($processors as $processor) {
            if ($processor->supports($update)) {
                // TODO: validate that returned state exists
                $newState = $processor->process($update, $currentConversation->context);

                $newConversation = $currentConversation->transitState($newState);

                $this->manager->save($newConversation);

                return;
            }
        }

        $fallbackProcessorClasses = $this->manager->getFallbackProcessors($currentConversation);
        $fallbackProcessors = $this->getStatefulFallbackProcessors($fallbackProcessorClasses, $currentConversation);

        foreach ($fallbackProcessors as $fallbackProcessor) {
            if ($fallbackProcessor->supports($update)) {
                // TODO: validate that returned state exists
                // TODO: refactor interfaces to consume not only context but just correct conversation object?
                $newState = $fallbackProcessor->process(
                    $update,
                    $currentConversation->name,
                    $currentConversation->state,
                    $currentConversation->context,
                );

                $newConversation = $currentConversation->transitState($newState);

                $this->manager->save($newConversation);

                return;
            }
        }

        $this->unsupportedStatefulProcessor->process(
            $update,
            $currentConversation->name,
            $currentConversation->state,
            $currentConversation->context,
        );

        if ($currentConversation->unprocessedStrategy === UnprocessedStrategy::LeaveUnprocessed) {
            return;
        }

        $this->processNonConversation($update);
    }

    private function processNonConversation(Update $update): void
    {
        foreach ($this->statelessProcessors as $statelessProcessor) {
            if ($statelessProcessor->supports($update)) {
                $statelessProcessor->process($update);

                if ($identifier = $this->startIdentifierProvider->provide($update)) {
                    $this->manager->startIfEntrypoint($statelessProcessor, $identifier->chatId, $identifier->userId);
                }

                return;
            }
        }

        $this->unsupportedStatelessProcessor->process($update);
    }
}
