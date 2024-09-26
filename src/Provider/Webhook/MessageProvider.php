<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider\Webhook;

use JsonException;
use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Model\Api\Response\BaseResponse;
use Temkaa\Botifier\Serializer\Serializer;

final readonly class MessageProvider
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function provide(): BaseResponse
    {
        $message = file_get_contents('php://input');

        return $this->serializer->deserialize(Action::GetUpdates, $message);
    }
}
