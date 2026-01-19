<?php
$pageTitle = 'Admin - Utenti';

$users = [
    ['id' => 1, 'username' => 'mrossi', 'email' => 'mario.rossi@uni.it', 'course' => 'Ing. Informatica', 'registration_date' => '2025-12-28', 'status' => 'active'],
    ['id' => 2, 'username' => 'cbianchi', 'email' => 'chiara.bianchi@uni.it', 'course' => 'Informatica', 'registration_date' => '2025-12-27', 'status' => 'active'],
    ['id' => 3, 'username' => 'aconti', 'email' => 'andrea.conti@uni.it', 'course' => 'Ing. Informatica', 'registration_date' => '2025-12-26', 'status' => 'suspended'],
    ['id' => 4, 'username' => 'lfermi', 'email' => 'luca.fermi@uni.it', 'course' => 'Medicina', 'registration_date' => '2025-12-25', 'status' => 'active'],
];
$total_users = count($users);

$adminContent = <<<'HTML'
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h3">Gestione Utenti</h1>
        <p class="text-body-secondary">Tutti gli utenti registrati sulla piattaforma</p>
    </div>
</div>

<!-- Filtri -->
<div class="card border-0 rounded-5 bg-body-tertiary mb-4">
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control rounded-4 border-0 bg-body" placeholder="Cerca per username...">
            </div>
            <div class="col-12 col-md-4">
                <select class="form-select rounded-4 border-0 bg-body">
                    <option>Tutti gli stati</option>
                    <option>Attivi</option>
                    <option>Sospesi</option>
                    <option>Bannati</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <select class="form-select rounded-4 border-0 bg-body">
                    <option>Tutti i corsi</option>
                    <option>Ing. Informatica</option>
                    <option>Informatica</option>
                    <option>Medicina</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Tabella utenti -->
<div class="card border-0 rounded-5 bg-body-tertiary">
    <div class="card-header border-0 rounded-top-5 bg-transparent p-4 border-bottom">
        <h5 class="mb-0">PHP_TOTAL_USERS utenti totali</h5>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="small text-body-secondary">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Corso</th>
                        <th>Data iscrizione</th>
                        <th>Stato</th>
                        <th class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody class="small">
                    PHP_USERS_ROWS
                </tbody>
            </table>
        </div>
    </div>
</div>
HTML;

// Generare le righe della tabella
$rows = '';
foreach ($users as $user) {
    $status_badge = $user['status'] === 'active' ?
        '<span class="badge bg-success rounded-3">Attivo</span>' :
        '<span class="badge bg-warning text-dark rounded-3">Sospeso</span>';

    $action_button = $user['status'] === 'active' ?
        '<button class="btn btn-sm btn-outline-danger rounded-3" onclick="suspendUser(' . $user['id'] . ')">Sospendi</button>' :
        '<button class="btn btn-sm btn-outline-success rounded-3" onclick="activateUser(' . $user['id'] . ')">Riattiva</button>';

    $rows .= <<<ROW
                    <tr>
                        <td><strong>{$user['username']}</strong></td>
                        <td>{$user['email']}</td>
                        <td>{$user['course']}</td>
                        <td>{$user['registration_date']}</td>
                        <td>$status_badge</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-primary rounded-3">Visualizza</a>
                            $action_button
                        </td>
                    </tr>
ROW;
}

$adminContent = str_replace('PHP_TOTAL_USERS', $total_users, $adminContent);
$adminContent = str_replace('PHP_USERS_ROWS', $rows, $adminContent);

$content = <<<HTML
$adminContent

<script>
function suspendUser(userId) {
    if (confirm('Sei sicuro di voler sospendere questo utente?')) {
        // Implementare la logica di sospensione
        console.log('Sospensione utente:', userId);
    }
}

function activateUser(userId) {
    if (confirm('Sei sicuro di voler riattivare questo utente?')) {
        // Implementare la logica di riattivazione
        console.log('Riattivazione utente:', userId);
    }
}
</script>
HTML;

include 'template/admin.php';
