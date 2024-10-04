<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command;

use Temkaa\Botifier\Enum\Command\Argument;

/**
 * @internal
 */
final readonly class Input implements InputInterface
{
    /**
     * @var array<string, string>
     */
    private array $arguments;

    /**
     * @var list<string>
     */
    private array $raw;

    /**
     * @param list<string> $arguments
     */
    public function __construct(
        array $arguments,
    ) {
        $this->arguments = $this->parse($arguments);
        $this->raw = $arguments;
    }

    public function getArgument(Argument $name): string
    {
        return $this->arguments[$name->value];
    }

    public function hasArgument(Argument $name): bool
    {
        return isset($this->arguments[$name->value]);
    }

    public function raw(): array
    {
        return $this->raw;
    }

    /**
     * @param list<string> $arguments
     *
     * @return array<string, string>
     */
    private function parse(array $arguments): array
    {
        $parsed = [];
        foreach ($arguments as $argument) {
            if (!str_starts_with($argument, '--') || !str_contains($argument, '=')) {
                continue;
            }

            [$name, $value] = explode('=', $argument, limit: 2);
            $parsed[$name] = $value;
        }

        return $parsed;
    }
}
