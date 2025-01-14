<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Enum\Conversation;

enum UnprocessedStrategy: string
{
    case ContinueProcessing = 'continue_processing';
    case LeaveUnprocessed = 'leave_unprocessed';
}
