<?php
session_start();

/**
 * Chat Controller
 * Displays the chat interface with conversation list and messages.
 */

require_once __DIR__ . '/../app/functions.php';
require_once __DIR__ . '/../app/Conversation.php';
require_once __DIR__ . '/../app/Message.php';

$pageTitle = "Chat";
$activePage = 'chat';

$me = $_SESSION['username'] ?? null;
$conversationModel = new Conversation();
$messageModel = new Message();

$chatList = $conversationModel->getUserConversations($me);
$activeConversationId = $_GET['conversation_id'] ?? ($chatList[0]['id'] ?? null);

$messages = [];
$activeChatUser = '';
$activeChatUsername = '';

if ($activeConversationId) {
    $participants = $conversationModel->getParticipants($activeConversationId);
    $usernames = array_column($participants, 'user_username');

    if (!in_array($me, $usernames)) {
        header("Location: chat.php");
        exit;
    }

    $messages = $messageModel->getByConversation($activeConversationId);
    $messageModel->markConversationAsRead($activeConversationId, $me);

    foreach ($participants as $p) {
        if ($p['user_username'] !== $me) {
            $activeChatUser = $p['first_name'] . ' ' . $p['surname'];
            $activeChatUsername = $p['user_username'];
            break;
        }
    }
}

// Process chat list for display
foreach ($chatList as &$chat) {
    $chat['active'] = ($chat['id'] == $activeConversationId);

    $participants = $conversationModel->getParticipants($chat['id']);
    foreach ($participants as $p) {
        if ($p['user_username'] !== $me) {
            $chat['display_name'] = $p['first_name'] . ' ' . $p['surname'];
            $chat['username'] = $p['user_username'];
            $chat['avatar_url'] = $p['avatar_url'];
            break;
        }
    }

    $lastMessage = $chat['last_message'] ?? 'Nessun messaggio';
    $chat['preview'] = mb_strlen($lastMessage) > 40
        ? mb_substr($lastMessage, 0, 37) . '...'
        : $lastMessage;
}
unset($chat);

ob_start();
?>

<div class="row flex-grow-1 g-3">

    <!-- LISTA CHAT -->
    <div class="col-12 col-md-4 d-flex">
        <div class="card border-0 rounded-5 bg-body-tertiary w-100">
            <div class="card-body p-3 p-md-4 overflow-auto">
                <h2 class="h5 mb-3">Chat</h2>
                <?php if (empty($chatList)): ?>
                    <div class="text-center text-body-secondary py-5">
                        <i class="bi bi-chat-dots display-6 mb-3"></i>
                        <p class="mb-0">Nessuna conversazione</p>
                        <small>Inizia una nuova chat con un utente</small>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($chatList as $chat): ?>
                            <a href="?conversation_id=<?= $chat['id'] ?>"
                                class="list-group-item list-group-item-action border-0 rounded-4 mb-2 bg-body <?= $chat['active'] ? 'active' : '' ?>">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="mb-1 fw-semibold text-truncate"><?= htmlspecialchars($chat['display_name']) ?></h6>
                                        <p class="mb-0 small text-body-secondary text-truncate"><?= htmlspecialchars($chat['preview']) ?></p>
                                    </div>
                                    <div class="d-flex flex-column align-items-end ms-2" style="min-width:48px;">
                                        <?php if (!empty($chat['last_message_at'])): ?>
                                            <small class="text-body-secondary mb-1"><?= (new DateTime($chat['last_message_at']))->format('H:i') ?></small>
                                        <?php endif; ?>
                                        <?php if (!empty($chat['unread_count'])): ?>
                                            <span class="badge bg-primary rounded-pill"><?= (int)$chat['unread_count'] ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- AREA CHAT -->
    <div class="col-12 col-md-8 d-flex">
        <div class="card border-0 rounded-5 bg-body-tertiary w-100 d-flex flex-column">

            <?php if ($activeConversationId && $activeChatUser): ?>
                <div class="card-header border-0 bg-transparent p-3 p-md-4 border-bottom">
                    <h3 class="h5 mb-0 fw-semibold"><?= htmlspecialchars($activeChatUser) ?></h3>
                    <p class="mb-0 small text-body-secondary"><?= $activeChatUsername ? '@' . htmlspecialchars($activeChatUsername) : '' ?></p>
                </div>

                <div class="card-body flex-grow-1 p-3 p-md-4 d-flex flex-column" id="messages-container" style="height: 50vh; overflow-y: auto;">
                    <?php
                    if (!empty($messages)):
                        $lastDate = null;
                        foreach ($messages as $msg):
                            $currentDate = (new DateTime($msg['created_at']))->format('Y-m-d');
                            if ($lastDate !== $currentDate):
                                $lastDate = $currentDate;
                                echo '<div class="text-center my-3"><span class="badge bg-body-secondary bg-opacity-25 px-3 py-1 rounded-pill">' . formatDateBadge($msg['created_at']) . '</span></div>';
                            endif;
                            echo renderMessageBubble($msg, $me);
                        endforeach;
                    endif;
                    ?>
                </div>

                <div class="card-footer border-0 bg-transparent p-3 p-md-4 border-top">
                    <form method="post" action="send-message.php" class="d-flex gap-2" id="message-form">
                        <input type="hidden" name="conversation_id" value="<?= $activeConversationId ?>">
                        <input type="text" name="message" class="form-control" placeholder="Scrivi un messaggio..." required autocomplete="off" id="message-input">
                        <button type="submit" class="btn btn-primary">Invia</button>
                    </form>
                </div>

            <?php else: ?>
                <div class="card-body d-flex flex-column justify-content-center align-items-center flex-grow-1">
                    <i class="bi bi-chat-text display-1 text-body-secondary mb-3 opacity-25"></i>
                    <h3 class="h5 mb-2">Nessuna chat selezionata</h3>
                    <p class="text-body-secondary text-center mb-0">
                        Seleziona una conversazione dalla lista<br>o avvia una nuova chat
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="assets/js/chat.js"></script>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/template/user.php';
?>