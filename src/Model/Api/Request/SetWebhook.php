<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Api\Request;

use GuzzleHttp\Psr7\LazyOpenStream;
use Temkaa\Botifier\Model\Shared\RequestInterface;

final readonly class SetWebhook implements RequestInterface
{
    public function __construct(
        private string $url,
        private ?LazyOpenStream $certificate = null,
    ) {
    }

    public function toArray(): array
    {
        $data = ['url' => $this->url];
        if ($this->certificate) {
            $data['certificate'] = $this->certificate;
        }

        return $data;
    }
}
