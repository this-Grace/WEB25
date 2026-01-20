<?php
session_start();

// TODO: proteggere questa pagina con controllo ruolo admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: /login.php');
//     exit;
// }

// Dati fittizi di esempio
$stats = [
    ['label' => 'Utenti totali', 'value' => 1250, 'icon' => 'bi-people-fill', 'variant' => 'primary'],
    ['label' => 'Report aperti', 'value' => 12, 'icon' => 'bi-flag-fill', 'variant' => 'danger'],
    ['label' => 'Post pubblicati', 'value' => 487, 'icon' => 'bi-chat-dots-fill', 'variant' => 'info'],
    ['label' => 'Team attivi', 'value' => 58, 'icon' => 'bi-diagram-3-fill', 'variant' => 'success'],
];

$latestUsers = [
    ['name' => 'Giulia Rossi', 'email' => 'giulia.rossi@uni.it', 'joined' => '2026-01-05'],
    ['name' => 'Luca Bianchi', 'email' => 'luca.bianchi@uni.it', 'joined' => '2026-01-03'],
    ['name' => 'Sara Verdi', 'email' => 'sara.verdi@uni.it', 'joined' => '2026-01-02'],
];

$openReports = [
    ['id' => '#4521', 'user' => 'mario.rossi', 'reason' => 'Contenuto inappropriato', 'created' => '2026-01-06'],
    ['id' => '#4519', 'user' => 'chiara.l', 'reason' => 'Spam', 'created' => '2026-01-05'],
];

$templateParams['pageTitle'] = 'Admin Dashboard';

ob_start();
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Benvenuto, Admin</h1>
        <p class="text-muted mb-0">Panoramica delle attività recenti</p>
    </div>
    <div class="d-flex gap-2">
        <a href="/admin-users.php" class="btn btn-outline-primary"><span class="bi bi-person-plus me-2" aria-hidden="true"></span>Gestisci utenti</a>
        <a href="/admin-reports.php" class="btn btn-primary"><span class="bi bi-flag-fill me-2" aria-hidden="true"></span>Vedi report</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <?php foreach ($stats as $stat): ?>
        <div class="col-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon d-inline-flex align-items-center justify-content-center rounded-circle bg-<?php echo htmlspecialchars($stat['variant']); ?> bg-opacity-10 text-<?php echo htmlspecialchars($stat['variant']); ?>">
                        <span class="bi <?php echo htmlspecialchars($stat['icon']); ?>" aria-hidden="true"></span>
                    </div>
                    <div>
                        <p class="text-muted mb-1 small"><?php echo htmlspecialchars($stat['label']); ?></p>
                        <h4 class="mb-0 fw-bold"><?php echo htmlspecialchars($stat['value']); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-body border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="h6 mb-0">Ultimi utenti</h2>
                    <a href="/admin-users.php" class="text-decoration-none small">Vedi tutti</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Iscritto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestUsers as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['joined']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-body border-0 pb-0">
                <h2 class="h6 mb-0">Report aperti</h2>
            </div>
            <div class="card-body">
                <?php if (empty($openReports)): ?>
                    <p class="text-muted mb-0">Nessun report aperto</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($openReports as $report): ?>
                            <div class="list-group-item d-flex flex-column gap-1 px-0">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="badge bg-danger-subtle text-danger"><?php echo htmlspecialchars($report['id']); ?></span>
                                    <span class="text-muted small"><?php echo htmlspecialchars($report['created']); ?></span>
                                </div>
                                <div class="fw-semibold"><?php echo htmlspecialchars($report['reason']); ?></div>
                                <div class="text-muted small">Utente: <?php echo htmlspecialchars($report['user']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$templateParams['userContent'] = ob_get_clean();

require_once 'template/admin-base.php';
?>