<?php

declare(strict_types=1);

namespace Tests\Integration\Command\Handler;

use DateTimeImmutable;
use JsonException;
use Temkaa\Botifier\Command\Handler\WebhookInfoCommand;
use Temkaa\Botifier\Command\Input;
use Temkaa\Botifier\Enum\Command\Argument;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Temkaa\Botifier\Exception\Command\InvalidCommandArgumentException;
use Temkaa\Botifier\Model\Api\Response\BaseResponse;
use Temkaa\Botifier\Model\Api\Response\Webhook;
use Tests\Helper\Service\Command\Output;
use Tests\Helper\Service\TelegramClient;

final class WebhookInfoCommandTest extends AbstractCommandTestCase
{
    /** @psalm-suppress PropertyNotSetInConstructor */
    private TelegramClient $client;

    /**
     * @throws JsonException
     */
    public function testExecute(): void
    {
        $now = (new DateTimeImmutable())->setTime(hour: 0, minute: 0, microsecond: 0);
        $raw = json_encode(
            [
                'ok'     => true,
                'result' => [
                    'url'                    => 'someurl.com',
                    'has_custom_certificate' => true,
                    'pending_update_count'   => 0,
                    'ip_address'             => '192.168.200.6',
                    'last_error_date'        => $now->getTimestamp(),
                    'last_error_message'     => 'last_error_message',
                    'max_connections'        => 20,
                    'allowed_updates'        => [],
                ],
            ],
            JSON_THROW_ON_ERROR,
        );
        $this->client->setResponses(
            [
                new BaseResponse(
                    success: true,
                    description: null,
                    errorCode: null,
                    result: new Webhook(
                        url: 'someurl.com',
                        hasCustomCertificate: true,
                        pendingUpdatesCount: 0,
                        ip: '192.168.200.6',
                        lastErrorDateTime: $now,
                        lastErrorMessage: 'last_error_message',
                        maxConnections: 20,
                        allowedUpdates: [],
                    ),
                    raw: $raw,
                ),
            ],
        );

        $command = new WebhookInfoCommand($this->client);

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
                'Successfully retrieved webhook info.',
                $raw,
            ],
            $output->getMessages(),
        );
    }

    /**
     * @throws JsonException
     */
    public function testExecuteWithInvalidArguments(): void
    {
        $command = new WebhookInfoCommand($this->client);

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
     * @return void
     * @throws JsonException
     */
    public function testExecuteWithNotSetWebhook(): void
    {
        $now = (new DateTimeImmutable())->setTime(hour: 0, minute: 0, microsecond: 0);
        $raw = json_encode(
            [
                'ok'     => true,
                'result' => [
                    'url'                    => 'someurl.com',
                    'has_custom_certificate' => true,
                    'pending_update_count'   => 0,
                ],
            ],
            JSON_THROW_ON_ERROR,
        );
        $this->client->setResponses(
            [
                new BaseResponse(
                    success: true,
                    description: null,
                    errorCode: null,
                    result: new Webhook(
                        url: 'someurl.com',
                        hasCustomCertificate: true,
                        pendingUpdatesCount: 0,
                        ip: null,
                        lastErrorDateTime: null,
                        lastErrorMessage: null,
                        maxConnections: null,
                        allowedUpdates: null,
                    ),
                    raw: $raw,
                ),
            ],
        );

        $command = new WebhookInfoCommand($this->client);

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
                'Successfully retrieved webhook info.',
                $raw,
            ],
            $output->getMessages(),
        );
    }

    /**
     * @throws JsonException
     */
    public function testExecuteWithUnsuccessfulResponse(): void
    {
        $raw = json_encode(
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'cannot retrieve webhook info',
            ],
            JSON_THROW_ON_ERROR,
        );

        $this->client->setResponses(
            [
                new BaseResponse(
                    success: false,
                    description: 'cannot retrieve webhook info',
                    errorCode: 400,
                    result: null,
                    raw: $raw,
                ),
            ],
        );

        $command = new WebhookInfoCommand($this->client);

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
                'An error occurred when trying retrieve bot webhook info.',
                $raw,
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
