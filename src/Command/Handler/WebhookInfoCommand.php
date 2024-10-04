<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command\Handler;

use JsonException;
use Temkaa\Botifier\Command\CommandInterface;
use Temkaa\Botifier\Command\InputInterface;
use Temkaa\Botifier\Command\OutputInterface;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\Command\Argument;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\Request\GetWebhookInfoRequest;
use Temkaa\Botifier\Service\TelegramClientInterface;

/**
 * @internal
 */
final readonly class WebhookInfoCommand extends BaseCommand implements CommandInterface
{
    private const array ARGUMENTS = [
        Argument::Token->value => ['optional' => false, 'description' => 'A token for your bot.'],
    ];
    private const string DESCRIPTION = 'This command allows you to print info about your webhook.';
    private const string SIGNATURE = 'webhook:info';

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
            new GetWebhookInfoRequest(),
            new Bot($input->getArgument(Argument::Token)),
        );

        $output->writeln(
            $response->success()
                ? 'Successfully retrieved webhook info.'
                : 'An error occurred when trying retrieve bot webhook info.',
        );

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
