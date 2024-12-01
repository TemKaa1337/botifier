<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Factory\Response\Nested\FileFactory;
use Temkaa\Botifier\Factory\Response\Nested\ResponseParametersFactory;
use Temkaa\Botifier\Interface\Response\FactoryInterface;
use Temkaa\Botifier\Interface\ResponseInterface;
use Temkaa\Botifier\Model\Response\UploadStickerFileResponse;

final readonly class UploadStickerFileResponseFactory implements FactoryInterface
{
    public function __construct(
        private FileFactory $fileFactory,
        private ResponseParametersFactory $responseParametersFactory
    ) {}

    public function create(array $message): ResponseInterface
    {
        return new UploadStickerFileResponse(
            $message['ok'],
            isset($message['result']) ? $this->fileFactory->create($message['result']) : null,
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            isset($message['parameters']) ? $this->responseParametersFactory->create($message['parameters']) : null
        );
    }

    public function supports(ApiMethod $method): bool
    {
        return $method === ApiMethod::UploadStickerFile;
    }
}
