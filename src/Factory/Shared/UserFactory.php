<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Model\Shared\User;

final readonly class UserFactory
{
    public function create(array $message): User
    {
        return new User(
            $message['id'],
            $message['is_bot'],
            $message['first_name'],
            $message['last_name'] ?? null,
            $message['username'] ?? null,
            $message['language_code'] === null ? null : Language::from($message['language_code']),
            $message['is_premium'] ?? null,
            $message['added_to_attachment_menu'] ?? null,
            $message['can_join_groups'] ?? null,
            $message['can_read_all_group_messages'] ?? null,
            $message['supports_inline_queries'] ?? null,
            $message['can_connect_to_business'] ?? null,
            $message['has_main_web_app'] ?? null
        );
    }
}
