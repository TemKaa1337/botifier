<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command\Handler;

use JsonException;
use Temkaa\Botifier\Command\InputInterface;
use Temkaa\Botifier\Enum\Command\Argument;
use Temkaa\Botifier\Exception\Command\InvalidCommandArgumentException;

abstract readonly class BaseCommand
{
    /**
     * @param array<string, array{optional: bool, description: string}> $supportedArguments
     */
    protected function generateDescription(
        string $commandSignature,
        string $commandDescription,
        array $supportedArguments,
    ): string {
        $indent = '  ';
        $descriptions = [
            $commandSignature,
            $indent."Description: $commandDescription",
            $indent."Arguments:",
        ];

        $indent = str_repeat($indent, times: 2);
        $maxArgumentLength = max(array_map('mb_strlen', array_keys($supportedArguments)));
        foreach ($supportedArguments as $argumentName => $requirements) {
            $spacesCountBetweenDescription = $maxArgumentLength - mb_strlen($argumentName) + 2;
            $requiredArgumentDescription = $requirements['optional'] ? 'optional' : 'required';

            $descriptions[] = sprintf(
                '%s%s (%s):%s%s',
                $indent,
                $argumentName,
                $requiredArgumentDescription,
                str_repeat(' ', $spacesCountBetweenDescription),
                $requirements['description'],
            );
        }

        return implode(PHP_EOL, $descriptions);
    }

    /**
     * @throws JsonException
     */
    protected function validateArguments(
        InputInterface $input,
        array $supportedArguments,
        string $commandSignature,
    ): void {
        foreach ($supportedArguments as $supportedArgumentName => ['optional' => $isOptional]) {
            if (!$isOptional && !$input->hasArgument(Argument::from($supportedArgumentName))) {
                throw new InvalidCommandArgumentException(
                    sprintf(
                        'Could not execute command "%s" as it has missing required argument "%s" in argument list "%s".',
                        $commandSignature,
                        $supportedArgumentName,
                        json_encode($input->raw(), JSON_THROW_ON_ERROR),
                    ),
                );
            }
        }
    }
}
