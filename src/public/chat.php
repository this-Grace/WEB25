<?php
session_start();

$pageTitle = "Chat";
$activePage = 'chat';
$pageWide  = true;

$me = $_SESSION['username'] ?? 'tu';

$chatList = [
    [
        'conversation_id' => 1,
        'username' => 'Marco Bianchi',
        'last_message' => 'Interessato al progetto',
        'active' => true
    ],
    [
        'conversation_id' => 2,
        'username' => 'Chiara Rossi',
        'last_message' => 'Quando possiamo sentirci?',
        'active' => false
    ]
];

$activeChatUser = 'Marco Bianchi';

$messages = [
    [
        'sender' => 'Marco',
        'text' => 'Ciao! Ho visto il tuo progetto',
        'me' => false
    ],
    [
        'sender' => 'Tu',
        'text' => 'Ciao! Ti va di parlarne?',
        'me' => true
    ]
];

ob_start();
?>

<div class="row flex-grow-1 g-3">

    <!-- LISTA CHAT -->
    <div class="col-12 col-md-4 d-flex">
        <div class="card border-0 rounded-5 bg-body-tertiary w-100">
            <div class="card-body p-3 p-md-4 overflow-auto">
                <h2 class="h5 mb-3">Chat</h2>

                <div class="list-group list-group-flush">
                    <?php foreach ($chatList as $chat): ?>
                        <button type="button"
                            class="list-group-item list-group-item-action border-0 rounded-4 mb-2 bg-body
                            <?php echo $chat['active'] ? 'active' : ''; ?>">
                            <h6 class="mb-1"><?php echo htmlspecialchars($chat['username']); ?></h6>
                            <p class="mb-1 small text-body-secondary">
                                <?php echo htmlspecialchars($chat['last_message']); ?>
                            </p>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- AREA CHAT -->
    <div class="col-12 col-md-8 d-flex">
        <div class="card border-0 rounded-5 bg-body-tertiary w-100 d-flex flex-column">

            <div class="card-header border-0 bg-transparent p-3 p-md-4 border-bottom">
                <h3 class="h5 mb-0"><?php echo htmlspecialchars($activeChatUser); ?></h3>
            </div>

            <div class="card-body flex-grow-1 overflow-auto p-3 p-md-4">
                <?php foreach ($messages as $msg): ?>
                    <div class="mb-3 <?php echo $msg['me'] ? 'text-end' : ''; ?>">
                        <div class="
                            <?php echo $msg['me']
                                ? 'bg-primary bg-opacity-10 text-primary'
                                : 'bg-body'; ?>
                            rounded-4 p-3 d-inline-block">
                            <p class="mb-0 small">
                                <strong><?php echo htmlspecialchars($msg['sender']); ?>:</strong>
                                <?php echo htmlspecialchars($msg['text']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="card-footer border-0 bg-transparent p-3 p-md-4 border-top">
                <form method="post" action="send-message.php" class="d-flex gap-2">
                    <input type="text"
                        name="message"
                        class="form-control rounded-4 border-0 bg-body"
                        placeholder="Scrivi un messaggio..."
                        required>
                    <button type="submit" class="btn btn-primary rounded-4">
                        Invia
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/template/base.php';
?>