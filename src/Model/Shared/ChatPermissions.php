<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

use Temkaa\Botifier\Trait\ArrayFilterTrait;

final readonly class ChatPermissions
{
    use ArrayFilterTrait;

    public function __construct(
        public ?bool $canSendMessages = null,
        public ?bool $canSendAudios = null,
        public ?bool $canSendDocuments = null,
        public ?bool $canSendPhotos = null,
        public ?bool $canSendVideos = null,
        public ?bool $canSendVideoNotes = null,
        public ?bool $canSendVoiceNotes = null,
        public ?bool $canSendPolls = null,
        public ?bool $canSendOtherMessages = null,
        public ?bool $canAddWebPagePreviews = null,
        public ?bool $canChangeInfo = null,
        public ?bool $canInviteUsers = null,
        public ?bool $canPinMessages = null,
        public ?bool $canManageTopics = null
    ) {}

    public function format(): array
    {
        return $this->filterNullable(
            [
                'can_send_messages'         => $this->canSendMessages,
                'can_send_audios'           => $this->canSendAudios,
                'can_send_documents'        => $this->canSendDocuments,
                'can_send_photos'           => $this->canSendPhotos,
                'can_send_videos'           => $this->canSendVideos,
                'can_send_video_notes'      => $this->canSendVideoNotes,
                'can_send_voice_notes'      => $this->canSendVoiceNotes,
                'can_send_polls'            => $this->canSendPolls,
                'can_send_other_messages'   => $this->canSendOtherMessages,
                'can_add_web_page_previews' => $this->canAddWebPagePreviews,
                'can_change_info'           => $this->canChangeInfo,
                'can_invite_users'          => $this->canInviteUsers,
                'can_pin_messages'          => $this->canPinMessages,
                'can_manage_topics'         => $this->canManageTopics,
            ]
        );
    }
}
