<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Utils;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\LazyOpenStream;
use SplFileInfo;
use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Exception\Webhook\InvalidCertificateException;
use Temkaa\Botifier\Http\Client;
use Temkaa\Botifier\Model\Api\Response;
use Temkaa\Botifier\Model\Bot;

// TODO: add asserts on succeeded response
// TODO: convert response array to model
final readonly class Webhook
{
    public function __construct(
        private Bot $bot,
        private Client $client,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function getInfo(): Response
    {
        return $this->client->send(Action::GetWebhookInfo, $this->bot);
    }

    /**
     * @throws GuzzleException
     */
    public function set(string $url, ?string $certificatePath = null): Response
    {
        $params = ['url' => $url];
        if ($certificatePath) {
            $file = new SplFileInfo($certificatePath);

            // TODO: move to separate input model and validate with my custom validator?
            // TODO: move to validator
            if (!$file->isFile() || !$file->isReadable()) {
                throw new InvalidCertificateException(
                    sprintf('Could not read certificate from file "%s".', $file->getFilename()),
                );
            }

            if ($file->getExtension() !== 'pub') {
                throw new InvalidCertificateException(
                    sprintf(
                        'Could not read certificate from file "%s" with non "pub" extension.',
                        $file->getFilename(),
                    ),
                );
            }

            $params['certificate'] = new LazyOpenStream($file->getRealPath(), 'rb');
        }

        return $this->client->send(Action::SetWebhook, $this->bot, $params);
    }

    /**
     * @throws GuzzleException
     */
    public function unset(): Response
    {
        return $this->client->send(Action::DeleteWebhook, $this->bot);
    }
}
