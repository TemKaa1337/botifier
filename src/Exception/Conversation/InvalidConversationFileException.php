<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Exception\Conversation;

use InvalidArgumentException;
use Temkaa\Botifier\Exception\BotifierExceptionInterface;

final class InvalidConversationFileException extends InvalidArgumentException implements BotifierExceptionInterface
{
}
