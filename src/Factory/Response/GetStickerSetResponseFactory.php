<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Factory\FactoryInterface;
use Temkaa\Botifier\Factory\Response\Nested\ResponseParametersFactory;
use Temkaa\Botifier\Factory\Response\Nested\StickerSetFactory;
use Temkaa\Botifier\Model\Response\GetStickerSetResponse;
use Temkaa\Botifier\Model\ResponseInterface;

final readonly class GetStickerSetResponseFactory implements FactoryInterface
{
    public function __construct(
        private StickerSetFactory $stickerSetFactory,
        private ResponseParametersFactory $responseParametersFactory
    ) {}

    public function create(array $message): ResponseInterface
    {
        return new GetStickerSetResponse(
            $message['ok'],
            isset($message['result']) ? $this->stickerSetFactory->create($message['result']) : null,
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            isset($message['parameters']) ? $this->responseParametersFactory->create($message['parameters']) : null
        );
    }

    public function supports(ApiMethod $method): bool
    {
        return $method === ApiMethod::GetStickerSet;
    }
}
