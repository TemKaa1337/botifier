<?php

declare(strict_types=1);

namespace Builder;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Temkaa\Botifier\Builder\ConversationBuilder;
use Temkaa\Botifier\Exception\Config\InvalidConversationConfigurationException;

final class ConversationBuilderTest extends TestCase
{
    /**
     * @return iterable<array{0: ConversationBuilder, 1: string}>
     */
    public static function getDataForDoesNotBuildDueToMissingRequiredMethodCallsTest(): iterable
    {
        yield [new ConversationBuilder(), 'Property "name" for Conversation must be filled.'];
        yield [(new ConversationBuilder())->name('name'), 'Property "startState" for Conversation must be filled.'];
        yield [
            (new ConversationBuilder())->name('name')->startState('state'),
            'Property "endState" for Conversation must be filled.',
        ];
        yield [
            (new ConversationBuilder())->name('name')->startState('state')->endState('end'),
            'Property "entrypoint" for Conversation must be filled.',
        ];
    }

    #[DataProvider('getDataForDoesNotBuildDueToMissingRequiredMethodCallsTest')]
    public function testDoesNotBuildDueToMissingRequiredMethodCalls(ConversationBuilder $builder, string $exceptionMessage): void
    {
        $this->expectException(InvalidConversationConfigurationException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $builder->build();
    }
}
