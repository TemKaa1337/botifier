<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Enum\Command;

/**
 * @internal
 */
enum Argument: string
{
    case CertificatePath = '--certificate_path';
    case Description = '--description';
    case Language = '--language';
    case Token = '--token';
    case Url = '--url';
}
