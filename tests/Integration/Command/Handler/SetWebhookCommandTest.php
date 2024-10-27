<?php

declare(strict_types=1);

namespace Tests\Integration\Command\Handler;

use JsonException;
use PHPUnit\Framework\Attributes\DataProvider;
use SplFileInfo;
use Temkaa\Botifier\Command\Handler\SetWebhookCommand;
use Temkaa\Botifier\Command\Input;
use Temkaa\Botifier\Enum\Command\Argument;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Temkaa\Botifier\Exception\Command\InvalidCommandArgumentException;
use Temkaa\Botifier\Model\Response\GeneralResponse;
use Tests\Helper\Service\Command\Output;
use Tests\Helper\Service\TelegramClient;

// TODO: test with real certificate path
final class SetWebhookCommandTest extends AbstractCommandTestCase
{
    /** @psalm-suppress PropertyNotSetInConstructor */
    private TelegramClient $client;

    public static function getDataForExecuteWithInvalidCertificatePathTest(): iterable
    {
        yield [
            [
                'bin/botifier',
                Argument::Token->value.'=token',
                Argument::Url->value.'=www.url.com',
                Argument::CertificatePath->value.'=non_existing_path',
            ],
            'Could not read certificate from file "non_existing_path".',
        ];

        $path = (new SplFileInfo(__DIR__.'/../../../Fixture/File/text_file.txt'))->getRealPath();
        yield [
            [
                'bin/botifier',
                Argument::Token->value.'=token',
                Argument::Url->value.'=www.url.com',
                Argument::CertificatePath->value.'='.$path,
            ],
            'Could not read certificate from file "text_file.txt" with non "pub" extension.',
        ];
    }

    /**
     * @throws JsonException
     */
    public function testExecute(): void
    {
        $raw = [
            'ok'          => true,
            'result'      => true,
            'description' => 'webhook set',
        ];

        $this->client->setResponses(
            [
                new GeneralResponse(
                    success: true,
                    description: 'webhook set',
                    errorCode: null,
                    result: true,
                    raw: $raw,
                ),
            ],
        );

        $command = new SetWebhookCommand($this->client);

        $certificateFile = new SplFileInfo(__DIR__.'/../../../Fixture/File/certificate.pub');

        $input = new Input(
            [
                'bin/botifier',
                Argument::Token->value.'=token',
                Argument::Url->value.'=www.url.com',
                Argument::CertificatePath->value.'='.$certificateFile->getRealPath(),
            ],
        );
        $output = new Output();

        $statusCode = $command->execute($input, $output);
        self::assertSame(ExitCode::Success->value, $statusCode);
        self::assertSame(
            [
                'Successfully set webhook for bot.',
                json_encode($raw, JSON_THROW_ON_ERROR),
            ],
            $output->getMessages(),
        );
    }

    /**
     * @throws JsonException
     */
    public function testExecuteWithInvalidArguments(): void
    {
        $command = new SetWebhookCommand($this->client);

        $input = new Input(['bin/botifier']);
        $output = new Output();

        $this->expectException(InvalidCommandArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Could not execute command "%s" as it has missing required argument "%s" in argument list "%s".',
                $command->getSignature(),
                Argument::Token->value,
                json_encode($input->raw(), JSON_THROW_ON_ERROR),
            ),
        );

        $command->execute($input, $output);
    }

    /**
     * @throws JsonException
     */
    #[DataProvider('getDataForExecuteWithInvalidCertificatePathTest')]
    public function testExecuteWithInvalidCertificatePath(array $arguments, string $exceptionMessage): void
    {
        $command = new SetWebhookCommand($this->client);

        $input = new Input($arguments);
        $output = new Output();

        $this->expectException(InvalidCommandArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $command->execute($input, $output);
    }

    /**
     * @throws JsonException
     */
    public function testExecuteWithUnsuccessfulResponse(): void
    {
        $raw = [
            'ok'          => false,
            'error_code'  => 400,
            'description' => 'description not set',
        ];

        $this->client->setResponses(
            [
                new GeneralResponse(
                    success: false,
                    description: 'description not set',
                    errorCode: 400,
                    result: null,
                    raw: $raw,
                ),
            ],
        );

        $command = new SetWebhookCommand($this->client);

        $input = new Input(
            [
                'bin/botifier',
                Argument::Token->value.'=token',
                Argument::Url->value.'=description',
            ],
        );
        $output = new Output();

        $statusCode = $command->execute($input, $output);
        self::assertSame(ExitCode::Failure->value, $statusCode);
        self::assertSame(
            [
                'An error occurred when trying to set webhook for bot.',
                json_encode($raw, JSON_THROW_ON_ERROR),
            ],
            $output->getMessages(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new TelegramClient();
        $this->client->reset();
    }
}
