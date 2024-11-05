<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

use Temkaa\Botifier\Trait\NullableArrayFilterTrait;

// TODO: add test on this
final readonly class KeyboardButtonRequestUsers
{
    use NullableArrayFilterTrait;

    public function __construct(
        private int $requestId,
        private ?bool $userIsBot = null,
        private ?bool $userIsPremium = null,
        private ?int $maxQuantity = null,
        private ?bool $requestName = null,
        private ?bool $requestUsername = null,
        private ?bool $requestPhoto = null,
    ) {
    }

    public function format(): array
    {
        return $this->filter(
            [
                'request_id'       => $this->requestId,
                'user_is_bot'      => $this->userIsBot,
                'user_is_premium'  => $this->userIsPremium,
                'max_quantity'     => $this->maxQuantity,
                'request_name'     => $this->requestName,
                'request_username' => $this->requestUsername,
                'request_photo'    => $this->requestPhoto,
            ],
        );
    }
}
