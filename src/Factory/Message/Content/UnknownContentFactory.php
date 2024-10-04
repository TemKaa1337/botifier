<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message\Content;

use Temkaa\Botifier\Enum\Message\Content\Type;
use Temkaa\Botifier\Factory\Message\ContentFactoryInterface;
use Temkaa\Botifier\Model\Response\Message\Content\UnknownContent;
use Temkaa\Botifier\Model\Response\Message\ContentInterface;

// TODO: create a better solution for reserved keys
/**
 * @internal
 */
final readonly class UnknownContentFactory implements ContentFactoryInterface
{
    private const array RESERVED_KEYS = ['message_id', 'from', 'chat', 'date', 'text'];

    public function create(array $message): ContentInterface
    {
        $messageKeys = array_keys($message);

        $contentMessage = $message;
        $contentKey = null;
        foreach ($messageKeys as $messageKey) {
            if (!in_array($messageKey, self::RESERVED_KEYS)) {
                $contentMessage = $message[$messageKey];
                $contentKey = $messageKey;

                break;
            }
        }

        return new UnknownContent($contentMessage, $contentKey, Type::Unknown);
    }

    public function supports(array $message): bool
    {
        return !isset($message['text']);
    }
}
