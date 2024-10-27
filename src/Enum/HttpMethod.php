<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Enum;

/**
 * @api
 */
enum HttpMethod: string
{
    case Get = 'GET';
    case Post = 'POST';
}
