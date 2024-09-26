<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command\Handler;

use JsonException;
use Temkaa\Botifier\Command\CommandInterface;
use Temkaa\Botifier\Command\InputInterface;
use Temkaa\Botifier\Command\OutputInterface;
use Temkaa\Botifier\Enum\Command\Argument;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Model\Api\Request\SetDescription;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Service\TelegramClientInterface;

final readonly class SetDescriptionCommand extends BaseCommand implements CommandInterface
{
    private const array ARGUMENTS = [
        Argument::Token->value       => ['optional' => false, 'description' => 'A token for your bot.'],
        Argument::Description->value => ['optional' => false, 'description' => 'A specified description for your bot.'],
        Argument::Language->value    => [
            'optional'    => false,
            'description' => 'A specified language for provided description.',
        ],
    ];
    private const string DESCRIPTION = 'This command allows you to set a description for your bot.';
    private const string SIGNATURE = 'description:set';

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

        $request = new SetDescription(
            $input->getArgument(Argument::Description),
            $input->getArgument(Argument::Language),
        );

        $response = $this->client->send(
            Action::SetDescription,
            new Bot($input->getArgument(Argument::Token)),
            $request,
        );

        if ($response->success()) {
            $output->writeln('Successfully set description for bot.');
        } else {
            $output->writeln('An error occurred when trying to set description for bot.');
        }

        $output->writeln($response->raw());

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
