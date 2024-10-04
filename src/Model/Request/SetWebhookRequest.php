<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\File;

/**
 * @api
 */
final readonly class SetWebhookRequest implements RequestInterface
{
    public function __construct(
        private string $url,
        private ?File $certificate = null,
    ) {
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetWebhook;
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getParameters(): array
    {
        $data = ['url' => $this->url];
        if ($this->certificate) {
            $data['certificate'] = $this->certificate;
        }

        return $data;
    }
}
