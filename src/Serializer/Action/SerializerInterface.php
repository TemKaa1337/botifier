<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer\Action;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Model\ResponseInterface;

/**
 * @internal
 */
interface SerializerInterface
{
    public function deserialize(array $message): ResponseInterface;

    public function supports(ApiMethod $action): bool;
}
