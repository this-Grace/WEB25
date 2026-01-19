<?php
$pageTitle = 'Admin - Utenti';
require_once __DIR__ . '/../app/User.php';

$message = '';
$userModel = new User();

// Gestione azioni
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $username = $_POST['username'] ?? '';

    try {
        if ($action === 'suspend' && !empty($username)) {
            if ($userModel->suspend($username)) {
                $message = '<div class="alert alert-success rounded-4">Utente sospeso con successo</div>';
            } else {
                $message = '<div class="alert alert-danger rounded-4">Errore durante la sospensione</div>';
            }
        } elseif ($action === 'activate' && !empty($username)) {
            if ($userModel->activate($username)) {
                $message = '<div class="alert alert-success rounded-4">Utente riattivato con successo</div>';
            } else {
                $message = '<div class="alert alert-danger rounded-4">Errore durante la riattivazione</div>';
            }
        }
    } catch (Exception $e) {
        error_log('Admin Action Error: ' . $e->getMessage());
        $message = '<div class="alert alert-danger rounded-4">Errore durante l\'operazione</div>';
    }
}

try {
    $users = $userModel->all();
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

    $actionBtn = $status === 'active'
        ? '<form method="POST" style="display:inline"><input type="hidden" name="action" value="suspend"><input type="hidden" name="username" value="' . htmlspecialchars($user['username']) . '"><button type="submit" class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm(\'Sei sicuro di voler sospendere questo utente?\')">Sospendi</button></form>'
        : '<form method="POST" style="display:inline"><input type="hidden" name="action" value="activate"><input type="hidden" name="username" value="' . htmlspecialchars($user['username']) . '"><button type="submit" class="btn btn-sm btn-outline-success rounded-3" onclick="return confirm(\'Sei sicuro di voler riattivare questo utente?\')">Riattiva</button></form>';

    $tableRows .= <<<ROW
    <tr>
        <td><strong>{$user['username']}</strong></td>
        <td>{$user['email']}</td>
        <td>{$user['degree_course']}</td>
        <td>{$user['created_at']}</td>
        <td>$statusBadge</td>
        <td class="text-end">
            <a href="profile.php?user={$user['username']}" class="btn btn-sm btn-primary rounded-3">Visualizza</a>
            $actionBtn
        </td>
    </tr>
ROW;
}

if (empty($tableRows)) {
    $tableRows = '<tr><td colspan="6" class="text-center text-body-secondary py-4">Nessun utente trovato</td></tr>';
}

$adminContent = <<<HTML
$message
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
        <h5 class="mb-0">$total_users utenti totali</h5>
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
                    $tableRows
                </tbody>
            </table>
        </div>
    </div>
</div>
HTML;

$content = $adminContent;

include 'template/admin.php';
