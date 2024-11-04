<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Webhook;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\File;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\GeneralResponse;

/**
 * @api
 * @implements RequestInterface<GeneralResponse>
 */
final readonly class SetRequest implements RequestInterface
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
