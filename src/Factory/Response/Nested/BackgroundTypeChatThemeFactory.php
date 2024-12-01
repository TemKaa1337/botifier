<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\BackgroundTypeChatTheme;

final readonly class BackgroundTypeChatThemeFactory
{
    public function create(array $message): BackgroundTypeChatTheme
    {
        return new BackgroundTypeChatTheme(
            $message['type'],
            $message['theme_name']
        );
    }
}
