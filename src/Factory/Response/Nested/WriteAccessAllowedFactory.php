<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\WriteAccessAllowed;

final readonly class WriteAccessAllowedFactory
{
    public function create(array $message): WriteAccessAllowed
    {
        return new WriteAccessAllowed(
            $message['from_request'] ?? null,
            $message['web_app_name'] ?? null,
            $message['from_attachment_menu'] ?? null
        );
    }
}
