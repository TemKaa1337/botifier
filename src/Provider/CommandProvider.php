<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use Temkaa\Botifier\Attribute\Command;
use Temkaa\Botifier\Command\CommandInterface;
use Temkaa\Botifier\Exception\Command\NotFoundException;
use Temkaa\Botifier\Model\Input\Message;
use Temkaa\Botifier\Validator\CommandValidator;
use Temkaa\SimpleContainer\Attribute\Bind\Tagged;

final readonly class CommandProvider
{
    public function __construct(
        #[Tagged(tag: 'command')]
        private array $commands,
    ) {
    }

    /**
     * @throws ReflectionException
     */
    public function provide(Message $message): CommandInterface
    {
        (new CommandValidator($this->commands))->validate();

        foreach ($this->commands as $command) {
            $reflection = new ReflectionClass($command);

            $signature = current($reflection->getAttributes(Command::class))->newInstance()->signature;

            if ($signature === $message) {
                return $command;
            }
        }

        throw new NotFoundException($message);
    }
}
