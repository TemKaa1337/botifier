<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command;

/**
 * @internal
 */
interface CommandInterface
{
    public function execute(InputInterface $input, OutputInterface $output): int;

    public function getDescription(): string;

    public function getSignature(): string;
}
