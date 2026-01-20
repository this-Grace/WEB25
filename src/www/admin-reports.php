<?php
session_start();

// TODO: proteggere questa pagina con controllo ruolo admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: /login.php');
//     exit;
// }

// Dati fittizi di esempio
$reports = [
    ['id' => 4521, 'reporter' => 'giulia.rossi', 'reported_user' => 'marco.neri', 'post_id' => 4, 'reason' => 'Contenuto inappropriato', 'description' => 'Il post contiene linguaggio offensivo', 'created' => '2026-01-06 10:30', 'status' => 'open'],
    ['id' => 4520, 'reporter' => 'luca.bianchi', 'reported_user' => 'anna.blu', 'post_id' => 8, 'reason' => 'Spam', 'description' => 'Post promozionale ripetuto', 'created' => '2026-01-05 15:20', 'status' => 'open'],
    ['id' => 4519, 'reporter' => 'sara.verdi', 'reported_user' => 'mario.rossi', 'post_id' => 12, 'reason' => 'Molestie', 'description' => 'Commenti inappropriati verso altri utenti', 'created' => '2026-01-05 09:45', 'status' => 'in_review'],
    ['id' => 4518, 'reporter' => 'chiara.l', 'reported_user' => 'paolo.m', 'post_id' => 15, 'reason' => 'Informazioni false', 'description' => 'Diffusione di informazioni non verificate', 'created' => '2026-01-04 14:10', 'status' => 'resolved'],
    ['id' => 4517, 'reporter' => 'federico.b', 'reported_user' => 'laura.v', 'post_id' => 20, 'reason' => 'Contenuto inappropriato', 'description' => 'Immagine non adeguata', 'created' => '2026-01-04 11:30', 'status' => 'dismissed'],
];

// TODO: Implementare azioni (visualizza, risolvi, respingi)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $reportId = $_POST['report_id'] ?? 0;

    // Placeholder per gestione azioni
    // switch($action) {
    //     case 'review': ...
    //     case 'resolve': ...
    //     case 'dismiss': ...
    // }
}

$templateParams['pageTitle'] = 'Gestione Report';

ob_start();
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Gestione Report</h1>
        <p class="text-muted mb-0">Visualizza e gestisci le segnalazioni degli utenti</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="window.print()">
            <span class="bi bi-printer me-2" aria-hidden="true"></span>Stampa
        </button>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-body border-0 d-flex align-items-center justify-content-between">
        <h2 class="h6 mb-0">Elenco report (<?php echo count($reports); ?>)</h2>
        <div class="d-flex gap-2">
            <input type="search" class="form-control form-control-sm" placeholder="Cerca report..." style="max-width: 250px;">
            <select class="form-select form-select-sm" style="max-width: 150px;">
                <option value="">Tutti gli stati</option>
                <option value="open">Aperti</option>
                <option value="in_review">In revisione</option>
                <option value="resolved">Risolti</option>
                <option value="dismissed">Respinti</option>
            </select>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Segnalante</th>
                        <th scope="col">Utente segnalato</th>
                        <th scope="col">Motivo</th>
                        <th scope="col">Descrizione</th>
                        <th scope="col">Data</th>
                        <th scope="col">Stato</th>
                        <th scope="col" class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td class="fw-semibold">#<?php echo htmlspecialchars($report['id']); ?></td>
                            <td><?php echo htmlspecialchars($report['reporter']); ?></td>
                            <td><?php echo htmlspecialchars($report['reported_user']); ?></td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">
                                    <?php echo htmlspecialchars($report['reason']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" title="<?php echo htmlspecialchars($report['description']); ?>">
                                    <?php echo htmlspecialchars($report['description']); ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($report['created']); ?></td>
                            <td>
                                <?php
                                $statusConfig = [
                                    'open' => ['class' => 'danger', 'label' => 'Aperto'],
                                    'in_review' => ['class' => 'warning', 'label' => 'In revisione'],
                                    'resolved' => ['class' => 'success', 'label' => 'Risolto'],
                                    'dismissed' => ['class' => 'secondary', 'label' => 'Respinto'],
                                ];
                                $config = $statusConfig[$report['status']];
                                ?>
                                <span class="badge bg-<?php echo $config['class']; ?>-subtle text-<?php echo $config['class']; ?>">
                                    <?php echo $config['label']; ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="Visualizza dettagli">
                                        <span class="bi bi-eye" aria-hidden="true"></span>
                                    </button>
                                    <?php if ($report['status'] === 'open'): ?>
                                        <button class="btn btn-outline-warning" title="Prendi in carico">
                                            <span class="bi bi-check-circle" aria-hidden="true"></span>
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($report['status'] !== 'resolved' && $report['status'] !== 'dismissed'): ?>
                                        <button class="btn btn-outline-success" title="Risolvi">
                                            <span class="bi bi-check-circle-fill" aria-hidden="true"></span>
                                        </button>
                                        <button class="btn btn-outline-danger" title="Respingi">
                                            <span class="bi bi-x-circle-fill" aria-hidden="true"></span>
                                        </button>
                                    <?php endif; ?>
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
            <span class="text-muted small">Mostrando <?php echo count($reports); ?> di <?php echo count($reports); ?> report</span>
            <nav aria-label="Paginazione report">
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