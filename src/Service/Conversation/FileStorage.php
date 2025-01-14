<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service\Conversation;

use JsonException;
use Temkaa\Botifier\Enum\Conversation\UnprocessedStrategy;
use Temkaa\Botifier\Model\CurrentConversation;
use Temkaa\Botifier\Model\CurrentConversation\Context;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function is_readable;
use function json_decode;
use function json_encode;
use function md5;
use function rtrim;
use function sprintf;
use function unlink;

final readonly class FileStorage implements StorageInterface
{
    public function __construct(
        private string $path,
    ) {
    }

    public function delete(int|string $chatId, int $userId): bool
    {
        $conversationFileName = $this->getFileName($chatId, $userId);

        if (!file_exists($conversationFileName)) {
            return true;
        }

        return unlink($conversationFileName);
    }

    /**
     * @throws JsonException
     */
    public function get(int|string $chatId, int $userId): ?CurrentConversation
    {
        $conversationFileName = $this->getFileName($chatId, $userId);

        if (!file_exists($conversationFileName) || !is_readable($conversationFileName)) {
            return null;
        }

        $json = file_get_contents($conversationFileName);

        /**
         * @var array{
         *     conversation: string,
         *     state: string,
         *     data: array<string, mixed>,
         *     unprocessedStrategy: string
         * } $data
         */
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        return new CurrentConversation(
            $chatId,
            $userId,
            $data['conversation'],
            $data['state'],
            new Context($data['data']),
            UnprocessedStrategy::from($data['unprocessedStrategy']),
        );
    }

    /**
     * @throws JsonException
     */
    public function set(CurrentConversation $currentConversation): bool
    {
        $conversationFileName = $this->getFileName($currentConversation->chatId, $currentConversation->userId);

        $result = file_put_contents(
            $conversationFileName,
            json_encode(
                [
                    'conversation'        => $currentConversation->name,
                    'state'               => $currentConversation->state,
                    'data'                => $currentConversation->context,
                    'unprocessedStrategy' => $currentConversation->unprocessedStrategy,
                ],
                JSON_THROW_ON_ERROR,
            ),
        );

        return $result !== false;
    }

    private function getFileName(int|string $chatId, int $userId): string
    {
        return sprintf(
            '%s/%s.json',
            rtrim($this->path, '/'),
            md5("$chatId|$userId"),
        );
    }
}
