<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Factory\Response\Nested\BotShortDescriptionFactory;
use Temkaa\Botifier\Factory\Response\Nested\ResponseParametersFactory;
use Temkaa\Botifier\Interface\Response\FactoryInterface;
use Temkaa\Botifier\Interface\ResponseInterface;
use Temkaa\Botifier\Model\Response\GetMyShortDescriptionResponse;

final readonly class GetMyShortDescriptionResponseFactory implements FactoryInterface
{
    public function __construct(
        private BotShortDescriptionFactory $botShortDescriptionFactory,
        private ResponseParametersFactory $responseParametersFactory
    ) {}

    public function create(array $message): ResponseInterface
    {
        return new GetMyShortDescriptionResponse(
            $message['ok'],
            isset($message['result']) ? $this->botShortDescriptionFactory->create($message['result']) : null,
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            isset($message['parameters']) ? $this->responseParametersFactory->create($message['parameters']) : null
        );
    }

    public function supports(ApiMethod $method): bool
    {
        return $method === ApiMethod::GetMyShortDescription;
    }
}
