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
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Service\TelegramClientInterface;

final readonly class UnsetWebhookCommand extends BaseCommand implements CommandInterface
{
    // TODO: move argument names to enum
    private const array ARGUMENTS = [
        Argument::Token->value => ['optional' => false, 'description' => 'A token for your bot.'],
    ];
    private const string DESCRIPTION = 'This command allows you to delete webhook from your bot.';
    private const string SIGNATURE = 'webhook:unset';

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

        $response = $this->client->send(
            Action::DeleteWebhook,
            new Bot($input->getArgument(Argument::Token)),
        );

        if ($response->success()) {
            $output->writeln('Successfully deleted webhook for bot.');
        } else {
            $output->writeln('An error occurred when trying to delete webhook for bot.');
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
