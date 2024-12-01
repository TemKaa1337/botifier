<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Model\Shared\CopyTextButton;

final readonly class CopyTextButtonFactory
{
    public function create(array $message): CopyTextButton
    {
        return new CopyTextButton(
            $message['text']
        );
    }
}
