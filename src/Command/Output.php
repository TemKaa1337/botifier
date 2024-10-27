<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command;

/**
 * @internal
 */
final readonly class Output implements OutputInterface
{
    /**
     * @param resource $output
     */
    public function __construct(
        private mixed $output,
    ) {
    }

    public function write(string ...$messages): void
    {
        foreach ($messages as $message) {
            fwrite($this->output, $message);
        }
    }

    public function writeln(string ...$messages): void
    {
        $this->write(...array_map(static fn (string $message): string => $message.PHP_EOL, $messages));
    }
}
