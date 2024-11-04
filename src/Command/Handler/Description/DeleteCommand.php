<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command\Handler\Description;

use JsonException;
use Temkaa\Botifier\Command\CommandInterface;
use Temkaa\Botifier\Command\Handler\BaseCommand;
use Temkaa\Botifier\Command\InputInterface;
use Temkaa\Botifier\Command\OutputInterface;
use Temkaa\Botifier\Enum\Command\Argument;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Model\Request\Description\DeleteRequest;
use Temkaa\Botifier\Service\TelegramClientInterface;

/**
 * @internal
 */
final readonly class DeleteCommand extends BaseCommand implements CommandInterface
{
    private const array ARGUMENTS = [
        Argument::Token->value    => ['optional' => false, 'description' => 'A token for your bot.'],
        Argument::Language->value => [
            'optional'    => true,
            'description' => 'A language for which you want to delete description.',
        ],
    ];
    private const string DESCRIPTION = 'This command allows you to delete a description from your bot.';
    private const string SIGNATURE = 'description:delete';

    public function __construct(
        private TelegramClientInterface $client,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->validateArguments($input, self::ARGUMENTS, self::SIGNATURE);

        if (
            $input->hasArgument(Argument::Language)
            && !$language = Language::tryFrom($input->getArgument(Argument::Language))
        ) {
            $output->writeln(
                sprintf(
                    'Could not convert language "%s" to enum "%s".',
                    $input->getArgument(Argument::Language),
                    Language::class,
                ),
            );

            return ExitCode::Failure->value;
        }

        $response = $this->client->send(
            new DeleteRequest($language ?? null),
        );

        $output->writeln(
            $response->success()
                ? 'Successfully deleted description for bot.'
                : 'An error occurred when trying to delete description from bot.',
        );

        $output->writeln(json_encode($response->raw(), JSON_THROW_ON_ERROR));

        return $response->success() ? ExitCode::Success->value : ExitCode::Failure->value;
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
