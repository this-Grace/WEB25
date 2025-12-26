<?php

require_once __DIR__ . '/../app/Users.php';

$usersModel = new User();
$users = $usersModel->all();
?>
<!doctype html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Utenti</title>
</head>

<body>
    <h1>Elenco utenti</h1>
    <?php if (empty($users)): ?>
        <p>Nessun utente trovato.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($users as $u): ?>
                <li>
                    <strong><?= htmlspecialchars($u['username']) ?></strong>
                    - <?= htmlspecialchars($u['email']) ?>
                    <?php if (!empty($u['bio'])): ?>
                        <div><?= nl2br(htmlspecialchars($u['bio'])) ?></div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>