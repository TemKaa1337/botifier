<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Model\Response\Message\User;

/**
 * @internal
 */
final readonly class UserFactory
{
    /**
     * @param array{
     *     from: array{
     *         id: int,
     *         username: string,
     *         first_name: string,
     *         is_bot: bool,
     *         language_code?: string
     *     }
     * } $message
     */
    public function create(array $message): User
    {
        $user = $message['from'];

        return new User(
            $user['id'],
            $user['username'],
            $user['first_name'],
            $user['is_bot'],
            isset($user['language_code']) ? Language::from($user['language_code']) : null,
        );
    }
}
