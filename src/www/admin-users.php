<?php
session_start();

require_once __DIR__ . '/../app/User.php';

$userModel = new User();

// Gestione azioni POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['user_id'])) {
    $action = $_POST['action'];
    $userId = (int)$_POST['user_id'];

    switch ($action) {
        case 'suspend':
            $userModel->suspend($userId);
            break;
        case 'restore':
            $userModel->restore($userId);
            break;
        case 'delete':
            $userModel->markAsDeleted($userId);
            break;
    }

    header('Location: /admin-users.php?status=' . ($_GET['status'] ?? ''));
    exit;
}

// Filtri
$statusFilter = $_GET['status'] ?? null;
$searchTerm = $_GET['search'] ?? null;

// Ottieni utenti filtrati
$users = $userModel->getFiltered($statusFilter, $searchTerm, 50);

$templateParams['pageTitle'] = 'Gestione Utenti';

// Configurazione tabella
$templateParams['tableTitle'] = 'Elenco utenti';
$templateParams['tableData'] = $users;
$templateParams['searchPlaceholder'] = 'Cerca utente...';
$templateParams['emptyMessage'] = 'Nessun utente trovato';

// Configurazione colonne
$templateParams['tableColumns'] = [
    ['field' => 'id', 'label' => 'ID'],
    ['field' => 'name', 'label' => 'Nome', 'class' => 'fw-semibold'],
    ['field' => 'email', 'label' => 'Email'],
    ['field' => 'university', 'label' => 'Università'],
    ['field' => 'joined', 'label' => 'Iscritto'],
    [
        'field' => 'status',
        'label' => 'Stato',
        'type' => 'badge',
        'badgeClass' => [
            'active' => 'success',
            'suspended' => 'warning',
            'deleted' => 'danger'
        ],
        'badgeLabel' => [
            'active' => 'Attivo',
            'suspended' => 'Sospeso',
            'deleted' => 'Eliminato'
        ]
    ]
];

// Configurazione filtro stato
$templateParams['statusFilter'] = [
    'active' => 'Attivi',
    'suspended' => 'Sospesi',
    'deleted' => 'Eliminati'
];

// Configurazione azioni
$templateParams['tableActions'] = function ($row) {
    $html = '';

    $html .= '<a href="/profile.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-outline-primary" title="Visualizza">';
    $html .= '<span class="bi bi-eye" aria-hidden="true"></span></a>';

    if ($row['status'] === 'active') {
        $html .= '<form method="POST" style="display: inline;">';
        $html .= '<input type="hidden" name="action" value="suspend">';
        $html .= '<input type="hidden" name="user_id" value="' . htmlspecialchars($row['id']) . '">';
        $html .= '<button type="submit" class="btn btn-outline-warning" title="Sospendi" onclick="return confirm(\'Sospendere questo utente?\')">';
        $html .= '<span class="bi bi-pause-circle" aria-hidden="true"></span></button></form>';
    } elseif ($row['status'] === 'suspended') {
        $html .= '<form method="POST" style="display: inline;">';
        $html .= '<input type="hidden" name="action" value="restore">';
        $html .= '<input type="hidden" name="user_id" value="' . htmlspecialchars($row['id']) . '">';
        $html .= '<button type="submit" class="btn btn-outline-success" title="Ripristina">';
        $html .= '<span class="bi bi-play-circle" aria-hidden="true"></span></button></form>';
    }

    if ($row['status'] !== 'deleted') {
        $html .= '<form method="POST" style="display: inline;">';
        $html .= '<input type="hidden" name="action" value="delete">';
        $html .= '<input type="hidden" name="user_id" value="' . htmlspecialchars($row['id']) . '">';
        $html .= '<button type="submit" class="btn btn-outline-danger" title="Elimina" onclick="return confirm(\'Eliminare definitivamente questo utente?\')">';
        $html .= '<span class="bi bi-trash" aria-hidden="true"></span></button></form>';
    }

    return $html;
};

ob_start();
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Gestione Utenti</h1>
        <p class="text-muted mb-0">Visualizza e gestisci tutti gli utenti registrati</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="window.print()">
            <span class="bi bi-printer me-2" aria-hidden="true"></span>Stampa
        </button>
    </div>
</div>

<?php require_once __DIR__ . '/partials/admin-table.php'; ?>

<?php
$templateParams['userContent'] = ob_get_clean();

require_once 'template/admin-base.php';
?>