<?php
$pageTitle = 'Admin - Segnalazioni';

$reports = [
    ['id' => 1, 'reason' => 'Comportamento inappropriato', 'reported_by' => 'mrossi', 'target' => 'lfermi', 'report_date' => '2025-12-28', 'status' => 'pending'],
    ['id' => 2, 'reason' => 'Contenuto offensivo', 'reported_by' => 'cbianchi', 'target' => 'Post di mrossi', 'report_date' => '2025-12-27', 'status' => 'blocked'],
    ['id' => 3, 'reason' => 'Spam', 'reported_by' => 'aconti', 'target' => 'Chat', 'report_date' => '2025-12-25', 'status' => 'resolved'],
    ['id' => 4, 'reason' => 'Frode', 'reported_by' => 'svillani', 'target' => 'Post sospetto', 'report_date' => '2025-12-24', 'status' => 'rejected'],
];
$stats = [
    'pending' => 23,
    'resolved' => 156,
    'blocked' => 12,
    'rejected' => 34
];

$adminContent = <<<'HTML'
<div class="mb-4">
    <h1 class="h3">Gestione Segnalazioni</h1>
    <p class="text-body-secondary">Revisione e moderazione delle segnalazioni degli utenti</p>
</div>

<!-- Statistiche -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-3">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h6 class="text-body-secondary small mb-2">Pendenti</h6>
                <h3 class="h2 mb-0">PHP_STAT_PENDING</h3>
                <small class="text-warning">In revisione</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h6 class="text-body-secondary small mb-2">Risolte</h6>
                <h3 class="h2 mb-0">PHP_STAT_RESOLVED</h3>
                <small class="text-success">Questo mese</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h6 class="text-body-secondary small mb-2">Bloccate</h6>
                <h3 class="h2 mb-0">PHP_STAT_BLOCKED</h3>
                <small class="text-danger">Azioni intraprese</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h6 class="text-body-secondary small mb-2">Rigettate</h6>
                <h3 class="h2 mb-0">PHP_STAT_REJECTED</h3>
                <small class="text-info">Non idonee</small>
            </div>
        </div>
    </div>
</div>

<!-- Filtri -->
<div class="card border-0 rounded-5 bg-body-tertiary mb-4">
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <select class="form-select rounded-4 border-0 bg-body">
                    <option>Tutti gli stati</option>
                    <option>Pendenti</option>
                    <option>In revisione</option>
                    <option>Risolte</option>
                    <option>Rigettate</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <select class="form-select rounded-4 border-0 bg-body">
                    <option>Tutti i motivi</option>
                    <option>Comportamento inappropriato</option>
                    <option>Contenuto offensivo</option>
                    <option>Spam</option>
                    <option>Frode</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <input type="text" class="form-control rounded-4 border-0 bg-body" placeholder="Cerca segnalazione...">
            </div>
        </div>
    </div>
</div>

<!-- Tabella segnalazioni -->
<div class="card border-0 rounded-5 bg-body-tertiary">
    <div class="card-header border-0 rounded-top-5 bg-transparent p-4 border-bottom">
        <h5 class="mb-0">Segnalazioni</h5>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="small text-body-secondary">
                    <tr>
                        <th>Motivo</th>
                        <th>Segnalato da</th>
                        <th>Bersaglio</th>
                        <th>Data</th>
                        <th>Stato</th>
                        <th class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody class="small">
                    PHP_REPORTS_ROWS
                </tbody>
            </table>
        </div>
    </div>
</div>
HTML;

// Generare le righe della tabella
$rows = '';
foreach ($reports as $report) {
    $status_badge = '';
    $action_button = '';

    switch ($report['status']) {
        case 'pending':
            $status_badge = '<span class="badge bg-warning text-dark rounded-3">In revisione</span>';
            $action_button = '<button class="btn btn-sm btn-outline-danger rounded-3" onclick="blockReport(' . $report['id'] . ')">Blocca</button>';
            break;
        case 'blocked':
            $status_badge = '<span class="badge bg-danger rounded-3">Bloccato</span>';
            $action_button = '<button class="btn btn-sm btn-outline-success rounded-3" onclick="unblockReport(' . $report['id'] . ')">Sblocca</button>';
            break;
        case 'resolved':
            $status_badge = '<span class="badge bg-success rounded-3">Risolto</span>';
            $action_button = '<button class="btn btn-sm btn-outline-secondary rounded-3" onclick="closeReport(' . $report['id'] . ')">Chiudi</button>';
            break;
        case 'rejected':
            $status_badge = '<span class="badge bg-info rounded-3">Rigettato</span>';
            $action_button = '<button class="btn btn-sm btn-outline-secondary rounded-3" onclick="closeReport(' . $report['id'] . ')">Chiudi</button>';
            break;
    }

    $rows .= <<<ROW
                    <tr>
                        <td>{$report['reason']}</td>
                        <td>{$report['reported_by']}</td>
                        <td>{$report['target']}</td>
                        <td>{$report['report_date']}</td>
                        <td>$status_badge</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-primary rounded-3">Rivedi</a>
                            $action_button
                        </td>
                    </tr>
ROW;
}

$adminContent = str_replace('PHP_STAT_PENDING', $stats['pending'], $adminContent);
$adminContent = str_replace('PHP_STAT_RESOLVED', $stats['resolved'], $adminContent);
$adminContent = str_replace('PHP_STAT_BLOCKED', $stats['blocked'], $adminContent);
$adminContent = str_replace('PHP_STAT_REJECTED', $stats['rejected'], $adminContent);
$adminContent = str_replace('PHP_REPORTS_ROWS', $rows, $adminContent);

$content = <<<HTML
$adminContent

<script>
function blockReport(reportId) {
    if (confirm('Sei sicuro di voler bloccare questo elemento?')) {
        // Implementare la logica di blocco
        console.log('Blocco segnalazione:', reportId);
    }
}

function unblockReport(reportId) {
    if (confirm('Sei sicuro di voler sbloccare questo elemento?')) {
        // Implementare la logica di sblocco
        console.log('Sblocco segnalazione:', reportId);
    }
}

function closeReport(reportId) {
    if (confirm('Sei sicuro di voler chiudere questa segnalazione?')) {
        // Implementare la logica di chiusura
        console.log('Chiusura segnalazione:', reportId);
    }
}
</script>
HTML;

include 'template/admin.php';
