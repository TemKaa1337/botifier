<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\WebAppData;

final readonly class WebAppDataFactory
{
    public function create(array $message): WebAppData
    {
        return new WebAppData(
            $message['data'],
            $message['button_text']
        );
    }
}
