<?php

declare(strict_types=1);

namespace Temkaa\Botifier;

use Temkaa\Botifier\Processor\UpdateProcessor;
use Temkaa\Botifier\Provider\Webhook\UpdateProviderInterface;

/**
 * @api
 */
final readonly class WebhookRunner implements RunnerInterface
{
    public function __construct(
        private UpdateProcessor $updateProcessor,
        private UpdateProviderInterface $updateProvider,
    ) {
    }

    public function run(): void
    {
        $update = $this->updateProvider->provide();

        $this->updateProcessor->process($update);
    }
}
