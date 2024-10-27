<?php

declare(strict_types=1);

namespace Tests\Integration\Command\Handler;

use JsonException;
use Temkaa\Botifier\Command\Handler\UnsetDescriptionCommand;
use Temkaa\Botifier\Command\Input;
use Temkaa\Botifier\Enum\Command\Argument;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Exception\Command\InvalidCommandArgumentException;
use Temkaa\Botifier\Model\Response\GeneralResponse;
use Tests\Helper\Service\Command\Output;
use Tests\Helper\Service\TelegramClient;

final class UnsetDescriptionCommandTest extends AbstractCommandTestCase
{
    /** @psalm-suppress PropertyNotSetInConstructor */
    private TelegramClient $client;

    /**
     * @throws JsonException
     */
    public function testExecute(): void
    {
        $raw = [
            'ok'          => true,
            'result'      => true,
            'description' => 'description set',
        ];

        $this->client->setResponses(
            [
                new GeneralResponse(
                    success: true,
                    description: 'description set',
                    errorCode: null,
                    result: true,
                    raw: $raw,
                ),
            ],
        );

        $command = new UnsetDescriptionCommand($this->client);

        $input = new Input(
            [
                'bin/botifier',
                Argument::Token->value.'=token',
            ],
        );
        $output = new Output();

        $statusCode = $command->execute($input, $output);
        self::assertSame(ExitCode::Success->value, $statusCode);
        self::assertSame(
            [
                'Successfully deleted description for bot.',
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
        $command = new UnsetDescriptionCommand($this->client);

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
    public function testExecuteWithNonExistingLanguage(): void
    {
        $command = new UnsetDescriptionCommand($this->client);

        $input = new Input(
            [
                'bin/botifier',
                Argument::Token->value.'=token',
                Argument::Language->value.'=non_existing_language',
            ],
        );
        $output = new Output();

        $statusCode = $command->execute($input, $output);
        self::assertSame(ExitCode::Failure->value, $statusCode);
        self::assertSame(
            [
                sprintf('Could not convert language "non_existing_language" to enum "%s".', Language::class),
            ],
            $output->getMessages(),
        );
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

        $command = new UnsetDescriptionCommand($this->client);

        $input = new Input(
            [
                'bin/botifier',
                Argument::Token->value.'=token',
            ],
        );
        $output = new Output();

        $statusCode = $command->execute($input, $output);
        self::assertSame(ExitCode::Failure->value, $statusCode);
        self::assertSame(
            [
                'An error occurred when trying to delete description from bot.',
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
