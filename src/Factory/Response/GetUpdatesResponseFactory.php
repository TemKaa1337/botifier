<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Factory\FactoryInterface;
use Temkaa\Botifier\Factory\Response\Nested\ResponseParametersFactory;
use Temkaa\Botifier\Factory\Response\Nested\UpdateFactory;
use Temkaa\Botifier\Model\Response\GetUpdatesResponse;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Model\ResponseInterface;

final readonly class GetUpdatesResponseFactory implements FactoryInterface
{
    public function __construct(
        private UpdateFactory $updateFactory,
        private ResponseParametersFactory $responseParametersFactory
    ) {}

    public function create(array $message): ResponseInterface
    {
        return new GetUpdatesResponse(
            $message['ok'],
            match (true) {
                isset($message['result']) => array_map(
                    fn (array $nested): Update => $this->updateFactory->create($nested),
                    $message['result']
                ),
                default                   => null,
            },
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            isset($message['parameters']) ? $this->responseParametersFactory->create($message['parameters']) : null
        );
    }

    public function supports(ApiMethod $method): bool
    {
        return $method === ApiMethod::GetUpdates;
    }
}
