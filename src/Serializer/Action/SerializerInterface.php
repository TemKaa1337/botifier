<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer\Action;

use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Model\Api\ResultInterface;

interface SerializerInterface
{
    public function deserialize(array $message): ResultInterface;

    public function supports(Action $action): bool;
}
