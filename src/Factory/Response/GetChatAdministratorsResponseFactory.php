<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response;

use InvalidArgumentException;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Factory\FactoryInterface;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberAdministratorFactory;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberBannedFactory;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberLeftFactory;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberMemberFactory;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberOwnerFactory;
use Temkaa\Botifier\Factory\Response\Nested\ChatMemberRestrictedFactory;
use Temkaa\Botifier\Factory\Response\Nested\ResponseParametersFactory;
use Temkaa\Botifier\Model\Response\GetChatAdministratorsResponse;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberAdministrator;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberBanned;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberLeft;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberMember;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberOwner;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberRestricted;
use Temkaa\Botifier\Model\ResponseInterface;

final readonly class GetChatAdministratorsResponseFactory implements FactoryInterface
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
        $factory = match (true) {
            !isset($message['result'])                                                => null,
            is_array($message['result']) && $message[0]['status'] === 'creator'       => $this->chatMemberOwnerFactory,
            is_array($message['result']) && $message[0]['status'] === 'administrator' => $this->chatMemberAdministratorFactory,
            is_array($message['result']) && $message[0]['status'] === 'member'        => $this->chatMemberMemberFactory,
            is_array($message['result']) && $message[0]['status'] === 'restricted'    => $this->chatMemberRestrictedFactory,
            is_array($message['result']) && $message[0]['status'] === 'left'          => $this->chatMemberLeftFactory,
            is_array($message['result']) && $message[0]['status'] === 'kicked'        => $this->chatMemberBannedFactory,
            default                                                                   => null,
        };

        return new GetChatAdministratorsResponse(
            $message['ok'],
            match (true) {
                !isset($message['result']) => null,
                $factory !== null          => array_map(
                    static fn (array $nested): ChatMemberOwner|ChatMemberAdministrator|ChatMemberMember|ChatMemberRestricted|ChatMemberLeft|ChatMemberBanned => $factory->create($nested),
                    $message['result']
                ),
                default                    => throw new InvalidArgumentException(sprintf('Could not find factory for message in factory: "%s".', self::class))
            },
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            isset($message['parameters']) ? $this->responseParametersFactory->create($message['parameters']) : null
        );
    }

    public function supports(ApiMethod $method): bool
    {
        return $method === ApiMethod::GetChatAdministrators;
    }
}
