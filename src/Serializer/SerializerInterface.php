<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Model\Response\Response;

/**
 * @internal
 */
interface SerializerInterface
{
    public function deserialize(ApiMethod $action, string $message): Response;
}
