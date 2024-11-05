<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message\Content;

use Temkaa\Botifier\Factory\Message\Content\Document\ThumbFactory;
use Temkaa\Botifier\Factory\Message\ContentFactoryInterface;
use Temkaa\Botifier\Model\Response\Message\Content\Document;
use Temkaa\Botifier\Model\Response\Message\ContentInterface;

final readonly class DocumentFactory implements ContentFactoryInterface
{
    public function __construct(
        private ThumbFactory $thumbFactory,
    ) {
    }

    /**
     * @param array{
     *     caption?: string,
     *     document: array{
     *         file_name: string,
     *         mime_type: string,
     *         thumb?: array{
     *             file_id: string,
     *             file_unique_id: string,
     *             file_size:int,
     *             width:int,
     *             height: int
     *         },
     *         thumbnail?: array{
     *             file_id: string,
     *             file_unique_id: string,
     *             file_size:int,
     *             width:int,
     *             height: int
     *         },
     *         file_id: string,
     *         file_unique_id: string,
     *         file_size: int
     *     }
     * } $message
     */
    public function create(array $message): ContentInterface
    {
        $document = $message['document'];

        $thumbnail = isset($document['thumbnail']) ? $this->thumbFactory->create($document['thumbnail']) : null;
        $thumb = isset($document['thumb']) ? $this->thumbFactory->create($document['thumb']) : null;

        return new Document(
            $message['caption'] ?? null,
            $document['file_name'],
            $document['mime_type'],
            $thumbnail,
            $thumb,
            $document['file_id'],
            $document['file_unique_id'],
            $document['file_size'],
        );
    }

    public function supports(array $message): bool
    {
        return isset($message['document']);
    }
}
