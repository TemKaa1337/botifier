<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command\Handler\Webhook;

use JsonException;
use Temkaa\Botifier\Command\CommandInterface;
use Temkaa\Botifier\Command\Handler\BaseCommand;
use Temkaa\Botifier\Command\InputInterface;
use Temkaa\Botifier\Command\OutputInterface;
use Temkaa\Botifier\Enum\Command\Argument;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Temkaa\Botifier\Model\Request\Webhook\DeleteRequest;
use Temkaa\Botifier\Service\TelegramClientInterface;

/**
 * @internal
 */
final readonly class DeleteCommand extends BaseCommand implements CommandInterface
{
    private const array ARGUMENTS = [
        Argument::Token->value => ['optional' => false, 'description' => 'A token for your bot.'],
    ];
    private const string DESCRIPTION = 'This command allows you to delete webhook from your bot.';
    private const string SIGNATURE = 'webhook:delete';

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
            new DeleteRequest(),
        );

        $output->writeln(
            $response->success()
                ? 'Successfully deleted webhook for bot.'
                : 'An error occurred when trying to delete webhook for bot.',
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
