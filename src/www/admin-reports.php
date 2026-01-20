<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/functions.php';

$db = $dbh->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['report_id'])) {
    $action = $_POST['action'];
    $reportId = (int)$_POST['report_id'];
    // TODO: Sostituire con l'ID dell'admin loggato
    $adminId = 1;

    $status = '';
    $message = '';

    switch ($action) {
        case 'review':
            $status = 'in_review';
            $message = 'Report preso in carico';
            break;
        case 'resolve':
            $status = 'resolved';
            $message = 'Report risolto con successo';
            break;
        case 'dismiss':
            $status = 'dismissed';
            $message = 'Report respinto';
            break;
    }

    if ($status) {
        try {
            $stmt = $db->prepare("UPDATE reports SET status = ?, reviewed_by = ?, reviewed_at = NOW() WHERE id = ?");
            $stmt->bind_param('sii', $status, $adminId, $reportId);
            $stmt->execute();
            $stmt->close();
            setFlashMessage('success', $message);
        } catch (Exception $e) {
            setFlashMessage('error', 'Si è verificato un errore.');
        }
    }

    redirect('/admin-reports.php');
}

// Filtri
$statusFilter = $_GET['status'] ?? '';
$searchTerm = $_GET['search'] ?? '';

// Query base
$query = "SELECT r.id, 
          CONCAT(reporter.name, ' ', reporter.surname) as reporter,
          CONCAT(reported.name, ' ', reported.surname) as reported_user,
          r.post_id, r.reason, r.description,
          DATE_FORMAT(r.created_at, '%Y-%m-%d %H:%i') as created,
          r.status
          FROM reports r
          JOIN users reporter ON r.reporter_id = reporter.id
          JOIN users reported ON r.reported_user_id = reported.id
          WHERE 1=1";

$params = [];
$types = '';

if ($statusFilter && in_array($statusFilter, ['open', 'in_review', 'resolved', 'dismissed'])) {
    $query .= " AND r.status = ?";
    $params[] = $statusFilter;
    $types .= 's';
}

if ($searchTerm) {
    $query .= " AND (reporter.name LIKE ? OR reporter.surname LIKE ? OR reported.name LIKE ? OR reported.surname LIKE ? OR r.description LIKE ?)";
    $searchParam = "%{$searchTerm}%";
    $params = array_merge($params, array_fill(0, 5, $searchParam));
    $types .= 'sssss';
}

$query .= " ORDER BY r.created_at DESC LIMIT 50";

$reports = [];
try {
    if (!empty($params)) {
        $stmt = $db->prepare($query);
        $refs = [];
        $refs[] = $types;
        foreach ($params as $key => $value) {
            $refs[] = &$params[$key];
        }
        call_user_func_array([$stmt, 'bind_param'], $refs);
        $stmt->execute();
        $result = $stmt->get_result();
        $reports = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        $result = $db->query($query);
        $reports = $result->fetch_all(MYSQLI_ASSOC);
    }
} catch (Exception $e) {
    // Gestione errore, es. log
}


// Traduzione ragioni
$reasonLabels = [
    'inappropriate_content' => 'Contenuto inappropriato',
    'spam' => 'Spam',
    'harassment' => 'Molestie',
    'false_information' => 'Informazioni false',
    'other' => 'Altro'
];

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
        <form method="GET" class="d-flex gap-2">
            <input type="search" name="search" class="form-control form-control-sm" placeholder="Cerca report..." style="max-width: 250px;" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <select name="status" class="form-select form-select-sm" style="max-width: 150px;" onchange="this.form.submit()">
                <option value="">Tutti gli stati</option>
                <option value="open" <?php echo $statusFilter === 'open' ? 'selected' : ''; ?>>Aperti</option>
                <option value="in_review" <?php echo $statusFilter === 'in_review' ? 'selected' : ''; ?>>In revisione</option>
                <option value="resolved" <?php echo $statusFilter === 'resolved' ? 'selected' : ''; ?>>Risolti</option>
                <option value="dismissed" <?php echo $statusFilter === 'dismissed' ? 'selected' : ''; ?>>Respinti</option>
            </select>
        </form>
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
                    <?php if (empty($reports)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Nessun report trovato.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reports as $report): ?>
                            <tr>
                                <td class="fw-semibold">#<?php echo htmlspecialchars($report['id']); ?></td>
                                <td><?php echo htmlspecialchars($report['reporter']); ?></td>
                                <td><?php echo htmlspecialchars($report['reported_user']); ?></td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        <?php echo htmlspecialchars($reasonLabels[$report['reason']] ?? $report['reason']); ?>
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
                                    $config = $statusConfig[$report['status']] ?? ['class' => 'secondary', 'label' => $report['status']];
                                    ?>
                                    <span class="badge bg-<?php echo $config['class']; ?>-subtle text-<?php echo $config['class']; ?>">
                                        <?php echo $config['label']; ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <?php if (!empty($report['post_id'])): ?>
                                        <a href="/post-detail.php?id=<?php echo $report['post_id']; ?>" class="btn btn-outline-primary" title="Visualizza post">
                                            <span class="bi bi-eye" aria-hidden="true"></span>
                                        </a>
                                        <?php endif; ?>
                                        <?php if ($report['status'] === 'open'): ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="review">
                                                <input type="hidden" name="report_id" value="<?php echo $report['id']; ?>">
                                                <button type="submit" class="btn btn-outline-warning" title="Prendi in carico">
                                                    <span class="bi bi-check-circle" aria-hidden="true"></span>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if (in_array($report['status'], ['open', 'in_review'])): ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="resolve">
                                                <input type="hidden" name="report_id" value="<?php echo $report['id']; ?>">
                                                <button type="submit" class="btn btn-outline-success" title="Risolvi" onclick="return confirm('Segnare questo report come risolto?')">
                                                    <span class="bi bi-check-circle-fill" aria-hidden="true"></span>
                                                </button>
                                            </form>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="dismiss">
                                                <input type="hidden" name="report_id" value="<?php echo $report['id']; ?>">
                                                <button type="submit" class="btn btn-outline-danger" title="Respingi" onclick="return confirm('Respingere questo report?')">
                                                    <span class="bi bi-x-circle-fill" aria-hidden="true"></span>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$templateParams['userContent'] = ob_get_clean();

require_once 'template/admin-base.php';
?>