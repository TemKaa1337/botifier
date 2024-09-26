<?php

declare(strict_types=1);

namespace Tests\Helper\Service\Command;

use Temkaa\Botifier\Command\OutputInterface;

final class Output implements OutputInterface
{
    /**
     * @var list<string>
     */
    private array $messages = [];

    /**
     * @return list<string>
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function write(string ...$messages): void
    {
        $this->messages = [...$this->messages, ...$messages];
    }

    public function writeln(string ...$messages): void
    {
        $this->messages = [...$this->messages, ...$messages];
    }
}
