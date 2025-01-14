<?php

declare(strict_types=1);

namespace Tests\Helper\Trait\Mock;

use DateTimeImmutable;

trait UpdateMockTrait
{
    private function getCallbackQuery(
        string $callbackQueryMessage,
        string $originalMessageText,
        DateTimeImmutable $createdAt,
    ): array {
        return [
            'update_id'      => 836780966,
            'callback_query' => [
                'id'            => '123456789123456789',
                'from'          => [
                    'id'            => 123451222,
                    'is_bot'        => false,
                    'first_name'    => 'first_name',
                    'username'      => 'username',
                    'language_code' => 'ru',
                ],
                'chat_instance' => '-123456789123456789',
                'message'       => [
                    'message_id' => 1234567,
                    'from'       => [
                        'id'            => 123451222222222,
                        'is_bot'        => false,
                        'first_name'    => 'first_name',
                        'username'      => 'username',
                        'language_code' => 'ru',
                    ],
                    'chat'       => [
                        'id'         => 772517840,
                        'first_name' => 'first_name',
                        'username'   => 'username',
                        'type'       => 'private',
                    ],
                    'date'       => $createdAt->getTimestamp(),
                    'text'       => $originalMessageText,
                ],
                'data'          => $callbackQueryMessage,
            ],
        ];
    }

    private function getEditedReplyTextMessage(
        string $repliedToMessage,
        string $editedReplyMessage,
        DateTimeImmutable $repliedToMessageCreatedAt,
        DateTimeImmutable $editedReplyMessageCreatedAt,
        DateTimeImmutable $editedReplyMessageUpdatedAt,
    ): array {
        return [
            'update_id'      => 836780966,
            'edited_message' => [
                'message_id'       => 1234567,
                'from'             => [
                    'id'            => 123451222,
                    'is_bot'        => false,
                    'first_name'    => 'first_name',
                    'username'      => 'username',
                    'language_code' => 'ru',
                ],
                'chat'             => [
                    'id'         => 772517840,
                    'first_name' => 'first_name',
                    'username'   => 'username',
                    'type'       => 'private',
                ],
                'date'             => $editedReplyMessageCreatedAt->getTimestamp(),
                'edit_date'        => $editedReplyMessageUpdatedAt->getTimestamp(),
                'reply_to_message' => [
                    'message_id' => 12345678,
                    'from'       => [
                        'id'            => 123451222,
                        'is_bot'        => false,
                        'first_name'    => 'first_name',
                        'username'      => 'username',
                        'language_code' => 'ru',
                    ],
                    'chat'       => [
                        'id'         => 772517840,
                        'first_name' => 'first_name',
                        'username'   => 'username',
                        'type'       => 'private',
                    ],
                    'date'       => $repliedToMessageCreatedAt->getTimestamp(),
                    'text'       => $repliedToMessage,
                ],
                'text'             => $editedReplyMessage,
            ],
        ];
    }

    private function getEditedTextMessage(
        string $message,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $editedAt,
    ): array {
        return [
            'update_id'      => 836780966,
            'edited_message' => [
                'message_id' => 1234567,
                'from'       => [
                    'id'            => 123451222,
                    'is_bot'        => false,
                    'first_name'    => 'first_name',
                    'username'      => 'username',
                    'language_code' => 'ru',
                ],
                'chat'       => [
                    'id'         => 772517840,
                    'first_name' => 'first_name',
                    'username'   => 'username',
                    'type'       => 'private',
                ],
                'date'       => $createdAt->getTimestamp(),
                'edit_date'  => $editedAt->getTimestamp(),
                'text'       => $message,
            ],
        ];
    }

    private function getRepliedTextMessage(
        string $originalMessage,
        string $replyMessage,
        DateTimeImmutable $originalMessageCreatedAt,
        DateTimeImmutable $replyMessageCreatedAt,
    ): array {
        return [
            'update_id' => 836780966,
            'message'   => [
                'message_id'       => 1234567,
                'from'             => [
                    'id'            => 123451222,
                    'is_bot'        => false,
                    'first_name'    => 'first_name',
                    'username'      => 'username',
                    'language_code' => 'ru',
                ],
                'chat'             => [
                    'id'         => 772517840,
                    'first_name' => 'first_name',
                    'username'   => 'username',
                    'type'       => 'private',
                ],
                'date'             => $originalMessageCreatedAt->getTimestamp(),
                'reply_to_message' => [
                    'message_id' => 12345678,
                    'from'       => [
                        'id'            => 123451222,
                        'is_bot'        => false,
                        'first_name'    => 'first_name',
                        'username'      => 'username',
                        'language_code' => 'ru',
                    ],
                    'chat'       => [
                        'id'         => 772517840,
                        'first_name' => 'first_name',
                        'username'   => 'username',
                        'type'       => 'private',
                    ],
                    'date'       => $replyMessageCreatedAt->getTimestamp(),
                    'text'       => $replyMessage,
                ],
                'text'             => $originalMessage,
            ],
        ];
    }

    private function getStickerMessage(DateTimeImmutable $createdAt): array
    {
        return [
            'update_id' => 836780966,
            'message'   => [
                'message_id' => 1234567,
                'from'       => [
                    'id'            => 123451222,
                    'is_bot'        => false,
                    'first_name'    => 'first_name',
                    'username'      => 'username',
                    'language_code' => 'ru',
                ],
                'chat'       => [
                    'id'         => 772517840,
                    'first_name' => 'first_name',
                    'username'   => 'username',
                    'type'       => 'private',
                ],
                'date'       => $createdAt->getTimestamp(),
                'sticker'    => [
                    'width'          => 512,
                    'height'         => 512,
                    'emoji'          => '\ud83e\udd7a',
                    'set_name'       => 'Barbiturato',
                    'is_animated'    => false,
                    'is_video'       => false,
                    'type'           => 'regular',
                    'thumbnail'      => [
                        'file_id'        => 'AAMCAgADGQEAAy1m-UGDBm2AlDMv2l-JT4a_u_AGTAACxAADmlyrHXTaQf0e-7R3AQAHbQADNgQ',
                        'file_unique_id' => 'AQADxAADmlyrHXI',
                        'file_size'      => 9306,
                        'width'          => 320,
                        'height'         => 320,
                    ],
                    'thumb'          => [
                        'file_id'        => 'AAMCAgADGQEAAy1m-UGDBm2AlDMv2l-JT4a_u_AGTAACxAADmlyrHXTaQf0e-7R3AQAHbQADNgQ',
                        'file_unique_id' => 'AQADxAADmlyrHXI',
                        'file_size'      => 9306,
                        'width'          => 320,
                        'height'         => 320,
                    ],
                    'file_id'        => 'CAACAgIAAxkBAAMtZvlBgwZtgJQzL9pfiU-Gv7vwBkwAAsQAA5pcqx102kH9Hvu0dzYE',
                    'file_unique_id' => 'AgADxAADmlyrHQ',
                    'file_size'      => 17354,
                ],
            ],
        ];
    }

    private function getTextMessage(string $message, DateTimeImmutable $createdAt): array
    {
        return [
            'update_id' => 836780966,
            'message'   => [
                'message_id' => 1234567,
                'from'       => [
                    'id'            => 123451222,
                    'is_bot'        => false,
                    'first_name'    => 'first_name',
                    'username'      => 'username',
                    'language_code' => 'ru',
                ],
                'chat'       => [
                    'id'         => 772517840,
                    'first_name' => 'first_name',
                    'username'   => 'username',
                    'type'       => 'private',
                ],
                'date'       => $createdAt->getTimestamp(),
                'text'       => $message,
            ],
        ];
    }
}
