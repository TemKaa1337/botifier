<?php

declare(strict_types=1);

namespace Command\Handler;

use PHPUnit\Framework\TestCase;
use Temkaa\Botifier\Command\Handler\HelpCommand;
use Temkaa\Botifier\Command\Handler\SetDescriptionCommand;
use Temkaa\Botifier\Command\Handler\SetWebhookCommand;
use Temkaa\Botifier\Command\Handler\UnsetDescriptionCommand;
use Temkaa\Botifier\Command\Handler\UnsetWebhookCommand;
use Temkaa\Botifier\Command\Handler\WebhookInfoCommand;
use Temkaa\Botifier\Command\Input;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Tests\Helper\Service\Command\Output;
use Tests\Helper\Service\TelegramClient;

final class HelpCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $client = new TelegramClient();
        $command = new HelpCommand([
            new SetDescriptionCommand($client),
            new SetWebhookCommand($client),
            new UnsetDescriptionCommand($client),
            new UnsetWebhookCommand($client),
            new WebhookInfoCommand($client),
        ]);

        $input = new Input(['bin/botifier', 'help']);
        $output = new Output();

        $exitCode = $command->execute($input, $output);
        self::assertSame(ExitCode::Success->value, $exitCode);
        self::assertSame(
            [
                'description:set',
                '  Description: This command allows you to set a description for your bot.',
                '  Arguments:',
                '    --token (required):        A token for your bot.',
                '    --description (required):  A specified description for your bot.',
                '    --language (required):     A specified language for provided description.',
                'webhook:set',
                '  Description: This command allows you to set a webhook for your bot.',
                '  Arguments:',
                '    --token (required):             A token for your bot.',
                '    --url (required):               A webhook url.',
                '    --certificate_path (optional):  A path to certificate if you want to use self-signed certificate.',
                'description:unset',
                '  Description: This command allows you to delete a description from your bot.',
                '  Arguments:',
                '    --token (required):     A token for your bot.',
                '    --language (optional):  A language for which you want to delete description.',
                'webhook:unset',
                '  Description: This command allows you to delete webhook from your bot.',
                '  Arguments:',
                '    --token (required):  A token for your bot.',
                'webhook:info',
                '  Description: This command allows you to print info about your webhook.',
                '  Arguments:',
                '    --token (required):  A token for your bot.',
            ],
            array_merge(
                ...array_map(
                    static fn (string $message): array => explode(PHP_EOL, $message),
                    $output->getMessages(),
                ),
            ),
        );
    }
}
