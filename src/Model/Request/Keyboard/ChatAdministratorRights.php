<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

use Temkaa\Botifier\Trait\NullableArrayFilterTrait;

// TODO: add test on this
final readonly class ChatAdministratorRights
{
    use NullableArrayFilterTrait;

    public function __construct(
        private bool $isAnonymous,
        private bool $canManageChat,
        private bool $canDeleteMessages,
        private bool $canManageVideoChats,
        private bool $canRestrictMembers,
        private bool $canPromoteMembers,
        private bool $canChangeInfo,
        private bool $canInviteUsers,
        private bool $canPostStories,
        private bool $canEditStories,
        private bool $canDeleteStories,
        private ?bool $canPostMessages = null,
        private ?bool $canEditMessages = null,
        private ?bool $canPinMessages = null,
        private ?bool $canManageTopics = null,
    ) {
    }

    public function format(): array
    {
        return $this->filter(
            [
                'is_anonymous'           => $this->isAnonymous,
                'can_manage_chat'        => $this->canManageChat,
                'can_delete_messages'    => $this->canDeleteMessages,
                'can_manage_video_chats' => $this->canManageVideoChats,
                'can_restrict_members'   => $this->canRestrictMembers,
                'can_promote_members'    => $this->canPromoteMembers,
                'can_change_info'        => $this->canChangeInfo,
                'can_invite_users'       => $this->canInviteUsers,
                'can_post_stories'       => $this->canPostStories,
                'can_edit_stories'       => $this->canEditStories,
                'can_delete_stories'     => $this->canDeleteStories,
                'can_post_messages'      => $this->canPostMessages,
                'can_edit_messages'      => $this->canEditMessages,
                'can_pin_messages'       => $this->canPinMessages,
                'can_manage_topics'      => $this->canManageTopics,
            ],
        );
    }
}
