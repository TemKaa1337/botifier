<?php

declare(strict_types=1);

namespace Tests\Integration\Command\Handler;

use PHPUnit\Framework\TestCase;

abstract class AbstractCommandTestCase extends TestCase
{
    abstract public function testExecute(): void;

    abstract public function testExecuteWithInvalidArguments(): void;

    abstract public function testExecuteWithUnsuccessfulResponse(): void;
}
