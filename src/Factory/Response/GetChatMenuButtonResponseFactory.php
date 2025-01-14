<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response;

use InvalidArgumentException;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Factory\FactoryInterface;
use Temkaa\Botifier\Factory\Response\Nested\ResponseParametersFactory;
use Temkaa\Botifier\Factory\Shared\MenuButtonCommandsFactory;
use Temkaa\Botifier\Factory\Shared\MenuButtonDefaultFactory;
use Temkaa\Botifier\Factory\Shared\MenuButtonWebAppFactory;
use Temkaa\Botifier\Model\Response\GetChatMenuButtonResponse;
use Temkaa\Botifier\Model\ResponseInterface;

final readonly class GetChatMenuButtonResponseFactory implements FactoryInterface
{
    public function __construct(
        private MenuButtonCommandsFactory $menuButtonCommandsFactory,
        private MenuButtonWebAppFactory $menuButtonWebAppFactory,
        private MenuButtonDefaultFactory $menuButtonDefaultFactory,
        private ResponseParametersFactory $responseParametersFactory
    ) {}

    public function create(array $message): ResponseInterface
    {
        return new GetChatMenuButtonResponse(
            $message['ok'],
            match (true) {
                !isset($message['result'])                => null,
                $message['result']['type'] === 'commands' => $this->menuButtonCommandsFactory->create($message['result']),
                $message['result']['type'] === 'web_app'  => $this->menuButtonWebAppFactory->create($message['result']),
                $message['result']['type'] === 'default'  => $this->menuButtonDefaultFactory->create($message['result']),
                default                                   => throw new InvalidArgumentException('Could not find factory for message.')
            },
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            isset($message['parameters']) ? $this->responseParametersFactory->create($message['parameters']) : null
        );
    }

    public function supports(ApiMethod $method): bool
    {
        return $method === ApiMethod::GetChatMenuButton;
    }
}
