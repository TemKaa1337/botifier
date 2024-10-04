<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Enum\Message\Content;

/**
 * @api
 */
enum Type
{
    case Command;
    case Text;
    case Unknown;
}
