<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Config\Conversation;

use Temkaa\Botifier\Exception\Config\InvalidConfigurationException;
use Temkaa\Botifier\Processor\ConversationProcessorInterface;
use function class_implements;
use function in_array;
use function sprintf;

final readonly class State
{
    /**
     * @param list<class-string<ConversationProcessorInterface>> $processors
     */
    public function __construct(
        public string $name,
        public array $processors,
    ) {
        $this->validateProcessors();
    }

    private function validateProcessors(): void
    {
        foreach ($this->processors as $processor) {
            $interfaces = class_implements($processor);
            if (
                $interfaces === false
                || !in_array(ConversationProcessorInterface::class, class_implements($processor), true)
            ) {
                throw new InvalidConfigurationException(
                    sprintf(
                        'Specified processor "%s" for state "%s" must implement "%s" interface.',
                        $processor,
                        $this->name,
                        ConversationProcessorInterface::class,
                    ),
                );
            }
        }
    }
}
