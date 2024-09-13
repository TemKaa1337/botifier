<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider;

use JsonException;
use Temkaa\Botifier\Factory\MessageFactory;
use Temkaa\Botifier\Model\Input\Message;

final class MessageProvider
{
    public function __construct(
        private readonly MessageFactory $messageFactory,
    )
    {
    }

    /**
     * @throws JsonException
     */
    public function provide(): Message
    {
        // TODO: add validators
        $content = file_get_contents('php://input');
        $content = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        return $this->messageFactory->create($content);
    }
}
