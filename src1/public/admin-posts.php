<?php
$pageTitle = 'Admin - Post';
$requireLogin = true;
require_once __DIR__ . '/../app/Post.php';

try {
    $postModel = new Post();
    $posts = $postModel->all();
    $total_posts = count($posts);
} catch (Exception $e) {
    error_log('Admin Posts Error: ' . $e->getMessage());
    $posts = [];
    $total_posts = 0;
}

// Funzione helper per generare badge di stato
function getPostStatusBadge($status) {
    $status = strtolower($status);
    $map = [
        'approvato' => ['bg-success', 'Pubblicato'],
        'pendente' => ['bg-warning text-dark', 'Sospeso'],
        'rifiutato' => ['bg-secondary', 'Rifiutato']
    ];
    
    if (isset($map[$status])) {
        return '<span class="badge ' . $map[$status][0] . ' rounded-3">' . $map[$status][1] . '</span>';
    }
    return '<span class="badge bg-secondary rounded-3">' . ucfirst($status) . '</span>';
}

// Funzione helper per generare bottone azione
function getPostActionButton($id, $status) {
    $status = strtolower($status);
    if ($status === 'approvato') {
        return '<button class="btn btn-sm btn-outline-danger rounded-3" onclick="removePost(' . $id . ')">Rimuovi</button>';
    } elseif ($status === 'pendente') {
        return '<button class="btn btn-sm btn-outline-success rounded-3" onclick="publishPost(' . $id . ')">Pubblica</button>';
    }
    return '<button class="btn btn-sm btn-outline-secondary rounded-3" disabled>Azione</button>';
}

// Genera righe tabella
$tableRows = '';
foreach ($posts as $post) {
    $status = $post['status'] ?? 'pendente';
    $statusBadge = getPostStatusBadge($status);
    $actionBtn = getPostActionButton($post['id'], $status);
    
    $tableRows .= <<<ROW
    <tr>
        <td><strong>{$post['title']}</strong></td>
        <td>{$post['user_username']}</td>
        <td>{$post['degree_course']}</td>
        <td>{$post['created_at']}</td>
        <td>$statusBadge</td>
        <td class="text-end">
            <a href="#" class="btn btn-sm btn-primary rounded-3">Visualizza</a>
            $actionBtn
        </td>
    </tr>
ROW;
}

if (empty($tableRows)) {
    $tableRows = '<tr><td colspan="6" class="text-center text-body-secondary py-4">Nessun post trovato</td></tr>';
}

$adminContent = <<<HTML
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h3">Gestione Post</h1>
        <p class="text-body-secondary">Moderazione e gestione dei post sulla piattaforma</p>
    </div>
</div>

<!-- Filtri -->
<div class="card border-0 rounded-5 bg-body-tertiary mb-4">
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control rounded-4 border-0 bg-body" placeholder="Cerca post...">
            </div>
            <div class="col-12 col-md-4">
                <select class="form-select rounded-4 border-0 bg-body">
                    <option>Tutti gli stati</option>
                    <option>Pubblicati</option>
                    <option>Sospesi</option>
                    <option>Rifiutati</option>
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

<!-- Tabella post -->
<div class="card border-0 rounded-5 bg-body-tertiary">
    <div class="card-header border-0 rounded-top-5 bg-transparent p-4 border-bottom">
        <h5 class="mb-0">$total_posts post attivi</h5>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="small text-body-secondary">
                    <tr>
                        <th>Titolo</th>
                        <th>Autore</th>
                        <th>Corso</th>
                        <th>Data pubblicazione</th>
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
function removePost(postId) {
    if (confirm('Sei sicuro di voler rimuovere questo post?')) {
        console.log('Rimozione post:', postId);
    }
}

function publishPost(postId) {
    if (confirm('Sei sicuro di voler pubblicare questo post?')) {
        console.log('Pubblicazione post:', postId);
    }
}
</script>
JS;

include 'template/admin.php';
