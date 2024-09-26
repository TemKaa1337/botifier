<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command\Handler;

use Temkaa\Botifier\Command\CommandInterface;
use Temkaa\Botifier\Command\InputInterface;
use Temkaa\Botifier\Command\OutputInterface;
use Temkaa\Botifier\Enum\Command\ExitCode;

final readonly class HelpCommand extends BaseCommand implements CommandInterface
{
    private const array ARGUMENTS = [];
    private const string DESCRIPTION = 'This command allows you to view all available commands and their arguments.';
    private const string SIGNATURE = 'help';

    /**
     * @param CommandInterface[] $commands
     */
    public function __construct(
        private array $commands,
    ) {
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->commands as $command) {
            $output->writeln($command->getDescription());
        }

        return ExitCode::Success->value;
    }

    public function getDescription(): string
    {
        return $this->generateDescription(self::SIGNATURE, self::DESCRIPTION, self::ARGUMENTS);
    }

    public function getSignature(): string
    {
        return self::SIGNATURE;
    }
}
