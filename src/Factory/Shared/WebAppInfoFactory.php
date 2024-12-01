<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Model\Shared\WebAppInfo;

final readonly class WebAppInfoFactory
{
    public function create(array $message): WebAppInfo
    {
        return new WebAppInfo(
            $message['url']
        );
    }
}
