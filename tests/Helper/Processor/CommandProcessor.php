<?php

declare(strict_types=1);

namespace Tests\Helper\Processor;

use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Processor\StatelessProcessorInterface;
use function str_starts_with;

final readonly class CommandProcessor implements StatelessProcessorInterface
{
    public function process(Update $update): void
    {
    }

    public function supports(Update $update): bool
    {
        return str_starts_with($update->message?->text ?? '', '/');
    }
}
