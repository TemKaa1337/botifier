<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Validator;

use ReflectionClass;
use Temkaa\Botifier\Attribute\Command;
use Temkaa\Botifier\Command\CommandInterface;
use Temkaa\Botifier\Exception\Command\InvalidConfigurationException;
use Temkaa\Botifier\Exception\Command\NotFoundException;

final readonly class CommandValidator
{
    public function __construct(
        private array $commands,
    ) {
    }

    public function validate(): void
    {
        foreach ($this->commands as $command) {
            if (!class_exists($command)) {
                throw new InvalidConfigurationException(
                    sprintf('Could not find command "%s".', $command),
                );
            }

            $reflection = new ReflectionClass($command);
            if (!$reflection->getAttributes(Command::class)) {
                throw new InvalidConfigurationException(
                    sprintf('Could not process command "%s" without "%s" attribute.', $command, Command::class),
                );
            }

            if (!$reflection->implementsInterface(CommandInterface::class)) {
                throw new InvalidConfigurationException(
                    sprintf('Command "%s" must implement interface "%s".', $command, CommandInterface::class),
                );
            }
        }
    }
}
