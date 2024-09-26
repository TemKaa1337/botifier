<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command;

use Temkaa\Botifier\Exception\Command\InvalidCommandArgumentException;

interface CommandInterface
{
    /**
     * @throws InvalidCommandArgumentException
     */
    public function execute(InputInterface $input, OutputInterface $output): int;

    public function getDescription(): string;

    public function getSignature(): string;
}
