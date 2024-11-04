<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message\Content;

use Temkaa\Botifier\Enum\Message\Content\Type;
use Temkaa\Botifier\Factory\Message\ContentFactoryInterface;
use Temkaa\Botifier\Model\Response\Message\Content\Command;
use Temkaa\Botifier\Model\Response\Message\ContentInterface;

/**
 * @internal
 */
final readonly class CommandFactory implements ContentFactoryInterface
{
    public function create(array $message): ContentInterface
    {
        $text = $message['text'];

        if (str_contains($text, ' ')) {
            [$signature, $parameters] = explode(' ', $text, limit: 2);
        } else {
            $signature = $text;
            $parameters = null;
        }

        return new Command(ltrim($signature, '/'), $parameters, Type::Command);
    }

    public function supports(array $message): bool
    {
        return isset($message['text']) && str_starts_with($message['text'], '/');
    }
}
