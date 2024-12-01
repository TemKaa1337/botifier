<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response;

use Temkaa\Botifier\Interface\ResponseInterface;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberAdministrator;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberBanned;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberLeft;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberMember;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberOwner;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberRestricted;
use Temkaa\Botifier\Model\Response\Nested\ResponseParameters;

final readonly class GetChatMemberResponse implements ResponseInterface
{
    public function __construct(
        public bool $ok,
        public ChatMemberOwner|ChatMemberAdministrator|ChatMemberMember|ChatMemberRestricted|ChatMemberLeft|ChatMemberBanned|null $result = null,
        public ?string $description = null,
        public ?int $errorCode = null,
        public ?ResponseParameters $parameters = null
    ) {}
}
