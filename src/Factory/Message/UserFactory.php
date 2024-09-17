<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Model\Input\Message\User;

final readonly class UserFactory
{
    public function create(array $message): User
    {
        $user = $message['from'];

        return new User(
            $user['id'],
            $user['username'],
            $user['first_name'],
            $user['is_bot'],
            Language::from($user['language_code']),
        );
    }
}
