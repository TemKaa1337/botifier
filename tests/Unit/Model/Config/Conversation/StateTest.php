<?php

declare(strict_types=1);

namespace Model\Config\Conversation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Temkaa\Botifier\Exception\Config\InvalidConfigurationException;
use Temkaa\Botifier\Model\Config\Conversation\State;
use Temkaa\Botifier\Processor\ConversationProcessorInterface;
use Tests\Helper\Processor\State1Processor;
use Tests\Helper\Service\EmptyClass;
use function sprintf;

final class StateTest extends TestCase
{
    /**
     * @return iterable<array{0: list<string>, 1: string}>
     */
    public static function getDataForFailsWithInvalidProcessorsTest(): iterable
    {
        yield [
            ['processor'],
            sprintf(
                'Specified processor "processor" for state "name" must implement "%s" interface.',
                ConversationProcessorInterface::class,
            ),
        ];
        yield [
            [EmptyClass::class],
            sprintf(
                'Specified processor "%s" for state "name" must implement "%s" interface.',
                EmptyClass::class,
                ConversationProcessorInterface::class,
            ),
        ];
    }

    /**
     * @param list<class-string<ConversationProcessorInterface>> $processors
     * @param string                                             $exceptionMessage
     *
     * @return void
     */
    #[DataProvider('getDataForFailsWithInvalidProcessorsTest')]
    public function testFailsWithInvalidProcessors(array $processors, string $exceptionMessage): void
    {
        $this->expectException(InvalidConfigurationException::class);
        $this->expectExceptionMessage($exceptionMessage);

        new State('name', $processors);
    }
}
