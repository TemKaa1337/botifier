<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response;

use InvalidArgumentException;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberAdministratorFactory;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberBannedFactory;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberLeftFactory;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberMemberFactory;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberOwnerFactory;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberRestrictedFactory;
use Temkaa\Botifier\Factory\Response\Nested\ResponseParametersFactory;
use Temkaa\Botifier\Interface\Response\FactoryInterface;
use Temkaa\Botifier\Interface\ResponseInterface;
use Temkaa\Botifier\Model\Response\GetChatMemberResponse;

final readonly class GetChatMemberResponseFactory implements FactoryInterface
{
    public function __construct(
        private ChatMemberOwnerFactory $chatMemberOwnerFactory,
        private ChatMemberAdministratorFactory $chatMemberAdministratorFactory,
        private ChatMemberMemberFactory $chatMemberMemberFactory,
        private ChatMemberRestrictedFactory $chatMemberRestrictedFactory,
        private ChatMemberLeftFactory $chatMemberLeftFactory,
        private ChatMemberBannedFactory $chatMemberBannedFactory,
        private ResponseParametersFactory $responseParametersFactory
    ) {}

    public function create(array $message): ResponseInterface
    {
        return new GetChatMemberResponse(
            $message['ok'],
            match (true) {
                !isset($message['result'])                       => null,
                $message['result']['status'] === 'creator'       => $this->chatMemberOwnerFactory->create($message['result']),
                $message['result']['status'] === 'administrator' => $this->chatMemberAdministratorFactory->create($message['result']),
                $message['result']['status'] === 'member'        => $this->chatMemberMemberFactory->create($message['result']),
                $message['result']['status'] === 'restricted'    => $this->chatMemberRestrictedFactory->create($message['result']),
                $message['result']['status'] === 'left'          => $this->chatMemberLeftFactory->create($message['result']),
                $message['result']['status'] === 'kicked'        => $this->chatMemberBannedFactory->create($message['result']),
                default                                          => throw new InvalidArgumentException('Could not find factory for message.')
            },
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            isset($message['parameters']) ? $this->responseParametersFactory->create($message['parameters']) : null
        );
    }

    public function supports(ApiMethod $method): bool
    {
        return $method === ApiMethod::GetChatMember;
    }
}
