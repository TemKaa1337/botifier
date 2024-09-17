<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Enum\Http;

enum Action: string
{
    case DeleteDescription = 'deleteMyDescription';
    case DeleteWebhook = 'deleteWebhook';
    case GetUpdates = 'getUpdates';
    case GetWebhookInfo = 'getWebhookInfo';
    case SendMessage = 'sendMessage';
    case SetDescription = 'setMyDescription';
    case SetWebhook = 'setWebhook';
}
