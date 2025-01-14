<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider\Webhook;

use Temkaa\Botifier\Model\Response\Nested\Update;

interface UpdateProviderInterface
{
    public function provide(): Update;
}
