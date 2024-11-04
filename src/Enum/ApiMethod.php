<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Enum;

/**
 * @api
 */
enum ApiMethod: string
{
    case DeleteDescription = 'deleteMyDescription';
    case DeleteWebhook = 'deleteWebhook';
    case GetUpdates = 'getUpdates';
    case GetWebhookInfo = 'getWebhookInfo';
    case SendDocument = 'sendDocument';
    case SendMessage = 'sendMessage';
    case SetDescription = 'setMyDescription';
    case SetWebhook = 'setWebhook';
}
