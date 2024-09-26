<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer;

use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Model\Api\Response\BaseResponse;

interface SerializerInterface
{
    public function deserialize(Action $action, string $message): BaseResponse;
}
