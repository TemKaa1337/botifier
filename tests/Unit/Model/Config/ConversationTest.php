<?php

declare(strict_types=1);

namespace Model\Config;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Temkaa\Botifier\Enum\Conversation\UnprocessedStrategy;
use Temkaa\Botifier\Exception\Config\InvalidConversationConfigurationException;
use Temkaa\Botifier\Model\Config\Conversation;
use Temkaa\Botifier\Model\Config\Conversation\State;
use Temkaa\Botifier\Processor\ConversationFallbackProcessorInterface;
use Temkaa\Botifier\Processor\ConversationProcessorInterface;
use Temkaa\Botifier\Processor\StatelessProcessorInterface;
use Tests\Helper\Processor\CommandProcessor;
use Tests\Helper\Processor\State1Processor;
use Tests\Helper\Service\EmptyClass;
use function sprintf;

final class ConversationTest extends TestCase
{
    /**
     * @return iterable<array{0: string, 1: string, 2: string, 3: list<State>, 4: list<string>, 5: string}>
     */
    public static function getDataForDoesNotInstantiateTest(): iterable
    {
        yield [
            '',
            'entrypointClass',
            'startState',
            [],
            [],
            'Cannot create a conversation with empty name.',
        ];
        yield [
            'name',
            'entrypointClass',
            'startState',
            [],
            [],
            sprintf(
                'Specified entrypoint "entrypointClass" for conversation "name" must implement "%s" interface.',
                StatelessProcessorInterface::class,
            ),
        ];
        yield [
            'name',
            EmptyClass::class,
            'startState',
            [],
            [],
            sprintf(
                'Specified entrypoint "%s" for conversation "name" must implement "%s" interface.',
                EmptyClass::class,
                StatelessProcessorInterface::class,
            ),
        ];
        yield [
            'name',
            CommandProcessor::class,
            'startState',
            [new State('state1', processors: [State1Processor::class])],
            [],
            'Specified start state "startState" for conversation "name" is missing in state list.',
        ];
        yield [
            'name',
            CommandProcessor::class,
            'startState',
            [
                new State('startState', processors: [State1Processor::class]),
                new State('state1', processors: [State1Processor::class]),
            ],
            ['fallback'],
            sprintf(
                'Specified fallback "fallback" for conversation "name" must implement "%s" interface.',
                ConversationProcessorInterface::class,
            ),
        ];
        yield [
            'name',
            CommandProcessor::class,
            'startState',
            [
                new State('startState', processors: [State1Processor::class]),
                new State('state1', processors: [State1Processor::class]),
            ],
            [EmptyClass::class],
            sprintf(
                'Specified fallback "%s" for conversation "name" must implement "%s" interface.',
                EmptyClass::class,
                ConversationProcessorInterface::class,
            ),
        ];
    }

    /**
     * @param non-empty-string                                           $name
     * @param class-string<StatelessProcessorInterface>                  $entrypoint
     * @param list<State>                                                $states
     * @param list<class-string<ConversationFallbackProcessorInterface>> $fallbacks
     */
    #[DataProvider('getDataForDoesNotInstantiateTest')]
    public function testDoesNotInstantiate(
        string $name,
        string $entrypoint,
        string $startState,
        array $states,
        array $fallbacks,
        string $expectedErrorMessage,
    ): void {
        $this->expectException(InvalidConversationConfigurationException::class);
        $this->expectExceptionMessage($expectedErrorMessage);

        new Conversation(
            $name,
            $entrypoint,
            $startState,
            endState: 'endState',
            states: $states,
            fallbacks: $fallbacks,
            unprocessedStrategy: UnprocessedStrategy::ContinueProcessing,
        );
    }
}
