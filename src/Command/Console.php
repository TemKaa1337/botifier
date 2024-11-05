<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command;

use Temkaa\Botifier\Command\Handler\HelpCommand;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Temkaa\Botifier\Exception\Command\InvalidCommandArgumentException;

/**
 * @internal
 */
final readonly class Console
{
    /**
     * @param CommandInterface[] $commands
     */
    public function __construct(
        private array $commands,
    ) {
    }

    public function execute(?string $signature, Input $input): int
    {
        // TODO: refactor
        $output = new Output(STDOUT);

        if ($signature === null) {
            foreach ($this->commands as $command) {
                if ($command instanceof HelpCommand) {
                    return $command->execute($input, $output);
                }
            }

            return ExitCode::Success->value;
        }

        foreach ($this->commands as $command) {
            if ($command->getSignature() === $signature) {
                try {
                    return $command->execute($input, $output);
                } catch (InvalidCommandArgumentException $e) {
                    $output->writeln($e->getMessage());

                    return ExitCode::Failure->value;
                }
            }
        }

        $output->writeln(
            sprintf('There is no command with signature: "%s".', $signature),
            'Fell free to check the list of allowed commands by using "bin/botifier help" command!',
        );

        return ExitCode::Failure->value;
    }
}
