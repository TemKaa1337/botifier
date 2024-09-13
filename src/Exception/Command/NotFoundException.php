<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Exception\Command;

use JsonException;
use LogicException;
use Temkaa\Botifier\Model\Input\Message;

final class NotFoundException extends LogicException
{
    /**
     * @throws JsonException
     */
    public function __construct(Message $message)
    {
        // TODO: add json serializable for message
        parent::__construct(
            message: sprintf(
                'Could not find command for message: "%s".',
                json_encode($message, JSON_THROW_ON_ERROR)
            )
        );
    }
}
