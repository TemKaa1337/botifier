<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Model\Response\Message\ContentInterface;

/**
 * @internal
 */
interface ContentFactoryInterface
{
    public function create(array $message): ContentInterface;

    public function supports(array $message): bool;
}
