<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\File;

final readonly class FileFactory
{
    public function create(array $message): File
    {
        return new File(
            $message['file_id'],
            $message['file_unique_id'],
            $message['file_size'] ?? null,
            $message['file_path'] ?? null
        );
    }
}
