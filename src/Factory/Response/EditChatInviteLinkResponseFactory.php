<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Factory\FactoryInterface;
use Temkaa\Botifier\Factory\Response\Nested\ChatInviteLinkFactory;
use Temkaa\Botifier\Factory\Response\Nested\ResponseParametersFactory;
use Temkaa\Botifier\Model\Response\EditChatInviteLinkResponse;
use Temkaa\Botifier\Model\ResponseInterface;

final readonly class EditChatInviteLinkResponseFactory implements FactoryInterface
{
    public function __construct(
        private ChatInviteLinkFactory $chatInviteLinkFactory,
        private ResponseParametersFactory $responseParametersFactory
    ) {}

    public function create(array $message): ResponseInterface
    {
        return new EditChatInviteLinkResponse(
            $message['ok'],
            isset($message['result']) ? $this->chatInviteLinkFactory->create($message['result']) : null,
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            isset($message['parameters']) ? $this->responseParametersFactory->create($message['parameters']) : null
        );
    }

    public function supports(ApiMethod $method): bool
    {
        return $method === ApiMethod::EditChatInviteLink;
    }
}
