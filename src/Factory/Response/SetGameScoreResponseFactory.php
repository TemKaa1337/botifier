<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Factory\FactoryInterface;
use Temkaa\Botifier\Factory\Response\Nested\MessageFactory;
use Temkaa\Botifier\Factory\Response\Nested\ResponseParametersFactory;
use Temkaa\Botifier\Model\Response\SetGameScoreResponse;
use Temkaa\Botifier\Model\ResponseInterface;

final readonly class SetGameScoreResponseFactory implements FactoryInterface
{
    public function __construct(
        private MessageFactory $messageFactory,
        private ResponseParametersFactory $responseParametersFactory
    ) {}

    public function create(array $message): ResponseInterface
    {
        return new SetGameScoreResponse(
            $message['ok'],
            match (true) {
                !isset($message['result'])                                 => null,
                is_bool($message['result']) && $message['result'] === true => $message['result'],
                default                                                    => $this->messageFactory->create($message['result'])
            },
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            isset($message['parameters']) ? $this->responseParametersFactory->create($message['parameters']) : null
        );
    }

    public function supports(ApiMethod $method): bool
    {
        return $method === ApiMethod::SetGameScore;
    }
}
