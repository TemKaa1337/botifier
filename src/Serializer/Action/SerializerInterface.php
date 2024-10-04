<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer\Action;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Model\Response\ResultInterface;

/**
 * @internal
 */
interface SerializerInterface
{
    public function deserialize(array $message): ResultInterface;

    public function supports(ApiMethod $action): bool;
}
