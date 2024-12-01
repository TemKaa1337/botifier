<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use InvalidArgumentException;
use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\PaidMediaPhoto;
use Temkaa\Botifier\Model\Response\Nested\PaidMediaPreview;
use Temkaa\Botifier\Model\Response\Nested\PaidMediaVideo;
use Temkaa\Botifier\Model\Response\Nested\TransactionPartnerUser;

final readonly class TransactionPartnerUserFactory
{
    public function __construct(
        private UserFactory $userFactory,
        private PaidMediaPreviewFactory $paidMediaPreviewFactory,
        private PaidMediaPhotoFactory $paidMediaPhotoFactory,
        private PaidMediaVideoFactory $paidMediaVideoFactory,
        private GiftFactory $giftFactory
    ) {}

    public function create(array $message): TransactionPartnerUser
    {
        $factory = match (true) {
            !isset($message['paid_media'])                                        => null,
            is_array($message['paid_media']) && $message[0]['type'] === 'preview' => $this->paidMediaPreviewFactory,
            is_array($message['paid_media']) && $message[0]['type'] === 'photo'   => $this->paidMediaPhotoFactory,
            is_array($message['paid_media']) && $message[0]['type'] === 'video'   => $this->paidMediaVideoFactory,
            default                                                               => null,
        };

        return new TransactionPartnerUser(
            $message['type'],
            $this->userFactory->create($message['user']),
            $message['invoice_payload'] ?? null,
            $message['subscription_period'] ?? null,
            match (true) {
                !isset($message['paid_media']) => null,
                $factory !== null              => array_map(
                    static fn (array $nested): PaidMediaPreview|PaidMediaPhoto|PaidMediaVideo => $factory->create($nested),
                    $message['paid_media']
                ),
                default                        => throw new InvalidArgumentException(sprintf('Could not find factory for message in factory: "%s".', self::class))
            },
            $message['paid_media_payload'] ?? null,
            isset($message['gift']) ? $this->giftFactory->create($message['gift']) : null
        );
    }
}
