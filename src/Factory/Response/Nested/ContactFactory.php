<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\Contact;

final readonly class ContactFactory
{
    public function create(array $message): Contact
    {
        return new Contact(
            $message['phone_number'],
            $message['first_name'],
            $message['last_name'] ?? null,
            $message['user_id'] ?? null,
            $message['vcard'] ?? null
        );
    }
}
