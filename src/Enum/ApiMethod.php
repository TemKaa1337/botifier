<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Enum;

enum ApiMethod: string
{
    case GetUpdates = 'getUpdates';
    case SetWebhook = 'setWebhook';
    case DeleteWebhook = 'deleteWebhook';
    case GetWebhookInfo = 'getWebhookInfo';
    case GetMe = 'getMe';
    case LogOut = 'logOut';
    case Close = 'close';
    case SendMessage = 'sendMessage';
    case ForwardMessage = 'forwardMessage';
    case ForwardMessages = 'forwardMessages';
    case CopyMessage = 'copyMessage';
    case CopyMessages = 'copyMessages';
    case SendPhoto = 'sendPhoto';
    case SendAudio = 'sendAudio';
    case SendDocument = 'sendDocument';
    case SendVideo = 'sendVideo';
    case SendAnimation = 'sendAnimation';
    case SendVoice = 'sendVoice';
    case SendVideoNote = 'sendVideoNote';
    case SendPaidMedia = 'sendPaidMedia';
    case SendMediaGroup = 'sendMediaGroup';
    case SendLocation = 'sendLocation';
    case SendVenue = 'sendVenue';
    case SendContact = 'sendContact';
    case SendPoll = 'sendPoll';
    case SendDice = 'sendDice';
    case SendChatAction = 'sendChatAction';
    case SetMessageReaction = 'setMessageReaction';
    case GetUserProfilePhotos = 'getUserProfilePhotos';
    case SetUserEmojiStatus = 'setUserEmojiStatus';
    case GetFile = 'getFile';
    case BanChatMember = 'banChatMember';
    case UnbanChatMember = 'unbanChatMember';
    case RestrictChatMember = 'restrictChatMember';
    case PromoteChatMember = 'promoteChatMember';
    case SetChatAdministratorCustomTitle = 'setChatAdministratorCustomTitle';
    case BanChatSenderChat = 'banChatSenderChat';
    case UnbanChatSenderChat = 'unbanChatSenderChat';
    case SetChatPermissions = 'setChatPermissions';
    case ExportChatInviteLink = 'exportChatInviteLink';
    case CreateChatInviteLink = 'createChatInviteLink';
    case EditChatInviteLink = 'editChatInviteLink';
    case CreateChatSubscriptionInviteLink = 'createChatSubscriptionInviteLink';
    case EditChatSubscriptionInviteLink = 'editChatSubscriptionInviteLink';
    case RevokeChatInviteLink = 'revokeChatInviteLink';
    case ApproveChatJoinRequest = 'approveChatJoinRequest';
    case DeclineChatJoinRequest = 'declineChatJoinRequest';
    case SetChatPhoto = 'setChatPhoto';
    case DeleteChatPhoto = 'deleteChatPhoto';
    case SetChatTitle = 'setChatTitle';
    case SetChatDescription = 'setChatDescription';
    case PinChatMessage = 'pinChatMessage';
    case UnpinChatMessage = 'unpinChatMessage';
    case UnpinAllChatMessages = 'unpinAllChatMessages';
    case LeaveChat = 'leaveChat';
    case GetChat = 'getChat';
    case GetChatAdministrators = 'getChatAdministrators';
    case GetChatMemberCount = 'getChatMemberCount';
    case GetChatMember = 'getChatMember';
    case SetChatStickerSet = 'setChatStickerSet';
    case DeleteChatStickerSet = 'deleteChatStickerSet';
    case GetForumTopicIconStickers = 'getForumTopicIconStickers';
    case CreateForumTopic = 'createForumTopic';
    case EditForumTopic = 'editForumTopic';
    case CloseForumTopic = 'closeForumTopic';
    case ReopenForumTopic = 'reopenForumTopic';
    case DeleteForumTopic = 'deleteForumTopic';
    case UnpinAllForumTopicMessages = 'unpinAllForumTopicMessages';
    case EditGeneralForumTopic = 'editGeneralForumTopic';
    case CloseGeneralForumTopic = 'closeGeneralForumTopic';
    case ReopenGeneralForumTopic = 'reopenGeneralForumTopic';
    case HideGeneralForumTopic = 'hideGeneralForumTopic';
    case UnhideGeneralForumTopic = 'unhideGeneralForumTopic';
    case UnpinAllGeneralForumTopicMessages = 'unpinAllGeneralForumTopicMessages';
    case AnswerCallbackQuery = 'answerCallbackQuery';
    case GetUserChatBoosts = 'getUserChatBoosts';
    case GetBusinessConnection = 'getBusinessConnection';
    case SetMyCommands = 'setMyCommands';
    case DeleteMyCommands = 'deleteMyCommands';
    case GetMyCommands = 'getMyCommands';
    case SetMyName = 'setMyName';
    case GetMyName = 'getMyName';
    case SetMyDescription = 'setMyDescription';
    case GetMyDescription = 'getMyDescription';
    case SetMyShortDescription = 'setMyShortDescription';
    case GetMyShortDescription = 'getMyShortDescription';
    case SetChatMenuButton = 'setChatMenuButton';
    case GetChatMenuButton = 'getChatMenuButton';
    case SetMyDefaultAdministratorRights = 'setMyDefaultAdministratorRights';
    case GetMyDefaultAdministratorRights = 'getMyDefaultAdministratorRights';
    case EditMessageText = 'editMessageText';
    case EditMessageCaption = 'editMessageCaption';
    case EditMessageMedia = 'editMessageMedia';
    case EditMessageLiveLocation = 'editMessageLiveLocation';
    case StopMessageLiveLocation = 'stopMessageLiveLocation';
    case EditMessageReplyMarkup = 'editMessageReplyMarkup';
    case StopPoll = 'stopPoll';
    case DeleteMessage = 'deleteMessage';
    case DeleteMessages = 'deleteMessages';
    case SendSticker = 'sendSticker';
    case GetStickerSet = 'getStickerSet';
    case GetCustomEmojiStickers = 'getCustomEmojiStickers';
    case UploadStickerFile = 'uploadStickerFile';
    case CreateNewStickerSet = 'createNewStickerSet';
    case AddStickerToSet = 'addStickerToSet';
    case SetStickerPositionInSet = 'setStickerPositionInSet';
    case DeleteStickerFromSet = 'deleteStickerFromSet';
    case ReplaceStickerInSet = 'replaceStickerInSet';
    case SetStickerEmojiList = 'setStickerEmojiList';
    case SetStickerKeywords = 'setStickerKeywords';
    case SetStickerMaskPosition = 'setStickerMaskPosition';
    case SetStickerSetTitle = 'setStickerSetTitle';
    case SetStickerSetThumbnail = 'setStickerSetThumbnail';
    case SetCustomEmojiStickerSetThumbnail = 'setCustomEmojiStickerSetThumbnail';
    case DeleteStickerSet = 'deleteStickerSet';
    case GetAvailableGifts = 'getAvailableGifts';
    case SendGift = 'sendGift';
    case AnswerInlineQuery = 'answerInlineQuery';
    case AnswerWebAppQuery = 'answerWebAppQuery';
    case SavePreparedInlineMessage = 'savePreparedInlineMessage';
    case SendInvoice = 'sendInvoice';
    case CreateInvoiceLink = 'createInvoiceLink';
    case AnswerShippingQuery = 'answerShippingQuery';
    case AnswerPreCheckoutQuery = 'answerPreCheckoutQuery';
    case GetStarTransactions = 'getStarTransactions';
    case RefundStarPayment = 'refundStarPayment';
    case EditUserStarSubscription = 'editUserStarSubscription';
    case SetPassportDataErrors = 'setPassportDataErrors';
    case SendGame = 'sendGame';
    case SetGameScore = 'setGameScore';
    case GetGameHighScores = 'getGameHighScores';
}
