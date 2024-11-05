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

    public function create(array $message): ContentInterface
    {
        return new Document(
            $message['file_name'],
            $message['mime_type'],
            $this->thumbFactory->create($message['thumbnail']),
            $this->thumbFactory->create($message['thumb']),
            $message['file_id'],
            $message['file_unique_id'],
            $message['file_size'],
        );
    }

    public function supports(array $message): bool
    {
        return isset($message['document']);
    }
}
