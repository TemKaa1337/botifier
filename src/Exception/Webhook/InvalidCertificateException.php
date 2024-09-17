<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Exception\Webhook;

use InvalidArgumentException;
use Temkaa\Botifier\Exception\BotifierExceptionInterface;

final class InvalidCertificateException extends InvalidArgumentException implements BotifierExceptionInterface
{
}
