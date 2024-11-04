<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Command\Handler\Webhook;

use JsonException;
use SplFileInfo;
use Temkaa\Botifier\Command\CommandInterface;
use Temkaa\Botifier\Command\Handler\BaseCommand;
use Temkaa\Botifier\Command\InputInterface;
use Temkaa\Botifier\Command\OutputInterface;
use Temkaa\Botifier\Enum\Command\Argument;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Temkaa\Botifier\Exception\Command\InvalidCommandArgumentException;
use Temkaa\Botifier\Model\File;
use Temkaa\Botifier\Model\Request\Webhook\SetRequest;
use Temkaa\Botifier\Service\TelegramClientInterface;

/**
 * @internal
 */
final readonly class SetCommand extends BaseCommand implements CommandInterface
{
    private const array ARGUMENTS = [
        Argument::Token->value           => ['optional' => false, 'description' => 'A token for your bot.'],
        Argument::Url->value             => ['optional' => false, 'description' => 'A webhook url.'],
        Argument::CertificatePath->value => [
            'optional'    => true,
            'description' => 'A path to certificate if you want to use self-signed certificate.',
        ],
    ];
    private const string DESCRIPTION = 'This command allows you to set a webhook for your bot.';
    private const string SIGNATURE = 'webhook:set';

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

        $certificate = $this->getCertificate($input);

        $response = $this->client->send(
            new SetRequest($input->getArgument(Argument::Url), $certificate),
        );

        $output->writeln(
            $response->success()
                ? 'Successfully set webhook for bot.'
                : 'An error occurred when trying to set webhook for bot.',
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

    private function getCertificate(InputInterface $input): ?File
    {
        $certificatePath = $input->hasArgument(Argument::CertificatePath)
            ? $input->getArgument(Argument::CertificatePath)
            : null;

        if ($certificatePath === null) {
            return null;
        }

        $file = new SplFileInfo($certificatePath);

        if (!$file->isFile() || !$file->isReadable()) {
            throw new InvalidCommandArgumentException(
                sprintf('Could not read certificate from file "%s".', $file->getFilename()),
            );
        }

        if ($file->getExtension() !== 'pub') {
            throw new InvalidCommandArgumentException(
                sprintf(
                    'Could not read certificate from file "%s" with non "pub" extension.',
                    $file->getFilename(),
                ),
            );
        }

        return File::fromFile($file->getRealPath());
    }
}
