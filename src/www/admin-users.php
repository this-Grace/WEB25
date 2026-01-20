<?php
session_start();

// TODO: proteggere questa pagina con controllo ruolo admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: /login.php');
//     exit;
// }

// Dati fittizi di esempio
$users = [
    ['id' => 1, 'name' => 'Giulia Rossi', 'email' => 'giulia.rossi@uni.it', 'university' => 'Università di Bologna', 'joined' => '2026-01-05', 'status' => 'active'],
    ['id' => 2, 'name' => 'Luca Bianchi', 'email' => 'luca.bianchi@uni.it', 'university' => 'Politecnico di Milano', 'joined' => '2026-01-03', 'status' => 'active'],
    ['id' => 3, 'name' => 'Sara Verdi', 'email' => 'sara.verdi@uni.it', 'university' => 'Sapienza Università di Roma', 'joined' => '2026-01-02', 'status' => 'active'],
    ['id' => 4, 'name' => 'Marco Neri', 'email' => 'marco.neri@uni.it', 'university' => 'Università di Padova', 'joined' => '2025-12-28', 'status' => 'suspended'],
    ['id' => 5, 'name' => 'Anna Blu', 'email' => 'anna.blu@uni.it', 'university' => 'Università di Milano', 'joined' => '2025-12-20', 'status' => 'active'],
];

// TODO: Implementare azioni (sospendi, elimina, ripristina)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $userId = $_POST['user_id'] ?? 0;

    // Placeholder per gestione azioni
    // switch($action) {
    //     case 'suspend': ...
    //     case 'delete': ...
    //     case 'restore': ...
    // }
}

$templateParams['pageTitle'] = 'Gestione Utenti';

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

<div class="card shadow-sm">
    <div class="card-header bg-body border-0 d-flex align-items-center justify-content-between">
        <h2 class="h6 mb-0">Elenco utenti (<?php echo count($users); ?>)</h2>
        <div class="d-flex gap-2">
            <input type="search" class="form-control form-control-sm" placeholder="Cerca utente..." style="max-width: 250px;">
            <select class="form-select form-select-sm" style="max-width: 150px;">
                <option value="">Tutti gli stati</option>
                <option value="active">Attivi</option>
                <option value="suspended">Sospesi</option>
            </select>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Università</th>
                        <th scope="col">Iscritto</th>
                        <th scope="col">Stato</th>
                        <th scope="col" class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td class="fw-semibold"><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['university']); ?></td>
                            <td><?php echo htmlspecialchars($user['joined']); ?></td>
                            <td>
                                <?php if ($user['status'] === 'active'): ?>
                                    <span class="badge bg-success-subtle text-success">Attivo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger">Sospeso</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="Visualizza">
                                        <span class="bi bi-eye" aria-hidden="true"></span>
                                    </button>
                                    <?php if ($user['status'] === 'active'): ?>
                                        <button class="btn btn-outline-warning" title="Sospendi">
                                            <span class="bi bi-pause-circle" aria-hidden="true"></span>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-outline-success" title="Ripristina">
                                            <span class="bi bi-play-circle" aria-hidden="true"></span>
                                        </button>
                                    <?php endif; ?>
                                    <button class="btn btn-outline-danger" title="Elimina">
                                        <span class="bi bi-trash" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-body border-0">
        <div class="d-flex align-items-center justify-content-between">
            <span class="text-muted small">Mostrando <?php echo count($users); ?> di <?php echo count($users); ?> utenti</span>
            <nav aria-label="Paginazione utenti">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Precedente</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Successivo</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php
$templateParams['userContent'] = ob_get_clean();

require_once 'template/admin-base.php';
?>