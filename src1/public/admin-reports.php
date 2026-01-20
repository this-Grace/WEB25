<?php
$pageTitle = 'Admin - Segnalazioni';
require_once __DIR__ . '/../app/Report.php';

try {
    $reportModel = new Report();
    $reports = $reportModel->all();
    $stats = $reportModel->getStats();
} catch (Exception $e) {
    error_log('Admin Reports Error: ' . $e->getMessage());
    $reports = [];
    $stats = ['pending' => 0, 'resolved' => 0, 'blocked' => 0, 'rejected' => 0];
}

// Funzione helper per badge stato segnalazione
function getReportStatusBadge($status)
{
    $status = strtolower(str_replace(' ', '_', $status));
    $map = [
        'pendente' => ['bg-warning text-dark', 'In revisione'],
        'bloccato' => ['bg-danger', 'Bloccato'],
        'risolte' => ['bg-success', 'Risolto'],
        'rigettate' => ['bg-info', 'Rigettato']
    ];

    if (isset($map[$status])) {
        return '<span class="badge ' . $map[$status][0] . ' rounded-3">' . $map[$status][1] . '</span>';
    }
    return '<span class="badge bg-secondary rounded-3">' . ucfirst($status) . '</span>';
}

// Funzione helper per bottone azione
function getReportActionButton($id, $status)
{
    $status = strtolower(str_replace(' ', '_', $status));

    $buttons = [
        'pendente' => '<button class="btn btn-sm btn-outline-danger rounded-3" onclick="blockReport(' . $id . ')">Blocca</button>',
        'bloccato' => '<button class="btn btn-sm btn-outline-success rounded-3" onclick="unblockReport(' . $id . ')">Sblocca</button>',
        'risolte' => '<button class="btn btn-sm btn-outline-secondary rounded-3" onclick="closeReport(' . $id . ')">Chiudi</button>',
        'rigettate' => '<button class="btn btn-sm btn-outline-secondary rounded-3" onclick="closeReport(' . $id . ')">Chiudi</button>'
    ];

    return $buttons[$status] ?? '<button class="btn btn-sm btn-outline-secondary rounded-3" disabled>Azione</button>';
}

// Genera righe tabella
$tableRows = '';
foreach ($reports as $report) {
    $statusBadge = getReportStatusBadge($report['status']);
    $actionBtn = getReportActionButton($report['id'], $report['status']);

    $tableRows .= <<<ROW
    <tr>
        <td>{$report['reason']}</td>
        <td>{$report['reporter_username']}</td>
        <td>{$report['reported_username']}</td>
        <td>{$report['created_at']}</td>
        <td>$statusBadge</td>
        <td class="text-end">
            <a href="#" class="btn btn-sm btn-primary rounded-3">Rivedi</a>
            $actionBtn
        </td>
    </tr>
ROW;
}

if (empty($tableRows)) {
    $tableRows = '<tr><td colspan="6" class="text-center text-body-secondary py-4">Nessuna segnalazione trovata</td></tr>';
}

$adminContent = <<<HTML
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
                <h3 class="h2 mb-0">{$stats['pending']}</h3>
                <small class="text-warning">In revisione</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h6 class="text-body-secondary small mb-2">Risolte</h6>
                <h3 class="h2 mb-0">{$stats['resolved']}</h3>
                <small class="text-success">Questo mese</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h6 class="text-body-secondary small mb-2">Bloccate</h6>
                <h3 class="h2 mb-0">{$stats['blocked']}</h3>
                <small class="text-danger">Azioni intraprese</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h6 class="text-body-secondary small mb-2">Rigettate</h6>
                <h3 class="h2 mb-0">{$stats['rejected']}</h3>
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
                    <option>Bloccati</option>
                    <option>Risolti</option>
                    <option>Rigettati</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <select class="form-select rounded-4 border-0 bg-body">
                    <option>Tutti i motivi</option>
                    <option>Comportamento inappropriato</option>
                    <option>Contenuto offensivo</option>
                    <option>Spam</option>
                    <option>Frode</option>
                    <option>Altro</option>
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
                        <th>Utente segnalato</th>
                        <th>Data</th>
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

$content = <<<JS
$adminContent

<script>
function blockReport(reportId) {
    if (confirm('Sei sicuro di voler bloccare questo elemento?')) {
        console.log('Blocco segnalazione:', reportId);
    }
}

function unblockReport(reportId) {
    if (confirm('Sei sicuro di voler sbloccare questo elemento?')) {
        console.log('Sblocco segnalazione:', reportId);
    }
}

function closeReport(reportId) {
    if (confirm('Sei sicuro di voler chiudere questa segnalazione?')) {
        console.log('Chiusura segnalazione:', reportId);
    }
}
</script>
JS;

include 'template/admin.php';
