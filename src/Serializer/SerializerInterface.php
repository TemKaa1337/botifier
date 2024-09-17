<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer;

use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Model\Api\Response;

interface SerializerInterface
{
    public function deserialize(Action $action, string $message): Response;
}
