<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Message;

use Temkaa\Botifier\Enum\Message\Content\Type;

/**
 * @api
 */
interface ContentInterface
{
    public function getType(): Type;
}
