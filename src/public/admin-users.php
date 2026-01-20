<?php
$pageTitle = 'Admin - Utenti';
require_once __DIR__ . '/../app/User.php';

$userModel = new User();
$searchQuery = '';

try {
    $users = $userModel->all();

    // Filtro di ricerca
    if (!empty($_POST['search'])) {
        $searchQuery = strtolower(trim($_POST['search']));
        $users = array_filter($users, function ($user) use ($searchQuery) {
            return strpos(strtolower($user['username']), $searchQuery) !== false ||
                strpos(strtolower($user['email']), $searchQuery) !== false ||
                strpos(strtolower($user['first_name']), $searchQuery) !== false ||
                strpos(strtolower($user['surname']), $searchQuery) !== false;
        });
    }

    $total_users = count($users);
} catch (Exception $e) {
    error_log('Admin Users Error: ' . $e->getMessage());
    $users = [];
    $total_users = 0;
}

// Funzione helper per status
function getUserStatus($user)
{
    if (empty($user['blocked_until'])) return 'active';
    $blockedUntil = new DateTime($user['blocked_until']);
    $now = new DateTime();
    return ($now < $blockedUntil) ? 'suspended' : 'active';
}

// Genera righe tabella
$tableRows = '';
foreach ($users as $user) {
    $status = getUserStatus($user);
    $statusBadge = $status === 'active'
        ? '<span class="badge bg-success rounded-3">Attivo</span>'
        : '<span class="badge bg-warning text-dark rounded-3">Sospeso</span>';

    $tableRows .= <<<ROW
    <tr>
        <td><strong>{$user['username']}</strong></td>
        <td>{$user['email']}</td>
        <td>{$user['first_name']} {$user['surname']}</td>
        <td>{$user['created_at']}</td>
        <td>$statusBadge</td>
        <td class="text-end">
            <a href="profile.php?user={$user['username']}" class="btn btn-sm btn-primary rounded-3">Visualizza</a>
        </td>
    </tr>
ROW;
}

if (empty($tableRows)) {
    $tableRows = '<tr><td colspan="6" class="text-center text-body-secondary py-4">Nessun utente trovato</td></tr>';
}

$adminContent = <<<HTML
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h3">Gestione Utenti</h1>
        <p class="text-body-secondary">Tutti gli utenti registrati sulla piattaforma</p>
    </div>
</div>

<!-- Filtri -->
<div class="card border-0 rounded-5 bg-body-tertiary mb-4">
    <div class="card-body p-4">
        <form method="POST" class="d-flex gap-3 align-items-end flex-wrap">
            <div class="flex-grow-1" style="min-width: 250px;">
                <input type="text" name="search" class="form-control rounded-4 border-0 bg-body" placeholder="Cerca per username, email, nome..." value="$searchQuery">
            </div>
            <button type="submit" class="btn btn-primary rounded-3">Cerca</button>
            <a href="admin-users.php" class="btn btn-secondary rounded-3">Resetta</a>
        </form>
    </div>
</div>

<!-- Tabella utenti -->
<div class="card border-0 rounded-5 bg-body-tertiary">
    <div class="card-header border-0 rounded-top-5 bg-transparent p-4 border-bottom">
        <h2 class="mb-0">$total_users utenti trovati</h2>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="small text-body-secondary">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Nome</th>
                        <th>Data iscrizione</th>
                        <th>Stato</th>
                        <th class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody class="small">
                    $tableRows
                </tbody>
            </table>
        </div>
    </div>
</div>
HTML;

$content = $adminContent;

include 'template/admin.php';
