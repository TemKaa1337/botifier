<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command;

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

    /**
     * @param string[] $arguments
     */
    public function execute(array $arguments): int
    {
        array_shift($arguments);

        // TODO: add colors
        $input = new Input($arguments);
        $output = new Output(STDOUT);
        $signature = $arguments ? array_shift($arguments) : null;

        if ($signature === null) {
            $output->writeln(
                'This script can execute a few useful commands!',
                'Fell free to check the list of allowed commands by using "bin/console help" command!',
            );

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
