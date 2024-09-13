<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Model\Input\Message\User;

final class UserFactory
{
    public function create(array $message): User
    {
        $user = $message['from'];

        return (new User())
            ->setFirstName($user['first_name'])
            ->setId($user['id'])
            ->setIsBot($user['is_bot'])
            ->setLanguage(Language::from($user['language_code']))
            ->setUsername($user['username']);
    }
}
