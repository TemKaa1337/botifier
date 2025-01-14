<?php

declare(strict_types=1);

namespace Tests\Helper\Provider\Webhook;

use Temkaa\Botifier\Factory\Response\Nested\UpdateFactory;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Provider\Webhook\UpdateProviderInterface;

final class UpdateProvider implements UpdateProviderInterface
{
    private static array $input;

    public function __construct(
        private readonly UpdateFactory $updateFactory,
    ) {
    }

    public function provide(): Update
    {
        return $this->updateFactory->create(self::$input);
    }

    public static function setInput(array $input): void
    {
        self::$input = $input;
    }
}
