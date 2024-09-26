<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared\Message;

use Temkaa\Botifier\Enum\Message\Content\Type;

interface ContentInterface
{
    public function getType(): Type;
}
