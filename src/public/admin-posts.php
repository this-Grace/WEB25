<?php
$pageTitle = 'Admin - Post';
$requireLogin = true;

$posts = [
    ['id' => 1, 'title' => 'App per la gestione dello studio', 'author_id' => 1, 'course' => 'Ing. Informatica', 'publish_date' => '2025-12-28', 'status' => 'published'],
    ['id' => 2, 'title' => 'Gamification per l\'apprendimento', 'author_id' => 2, 'course' => 'Informatica', 'publish_date' => '2025-12-27', 'status' => 'published'],
    ['id' => 3, 'title' => 'Assistente AI per tesi', 'author_id' => 3, 'course' => 'Ing. Informatica', 'publish_date' => '2025-12-26', 'status' => 'suspended'],
    ['id' => 4, 'title' => 'Social network universitario', 'author_id' => 4, 'course' => 'Medicina', 'publish_date' => '2025-12-25', 'status' => 'published'],
];
$total_posts = 4;

$adminContent = <<<'HTML'
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
                    <option>Rimossi</option>
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
        <h5 class="mb-0">PHP_TOTAL_POSTS post attivi</h5>
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
                    PHP_POSTS_ROWS
                </tbody>
            </table>
        </div>
    </div>
</div>
HTML;

// Generare le righe della tabella
$rows = '';
foreach ($posts as $post) {
    $status_badge = '';
    $action_button = '';

    if ($post['status'] === 'published') {
        $status_badge = '<span class="badge bg-success rounded-3">Pubblicato</span>';
        $action_button = '<button class="btn btn-sm btn-outline-danger rounded-3" onclick="removePost(' . $post['id'] . ')">Rimuovi</button>';
    } elseif ($post['status'] === 'suspended') {
        $status_badge = '<span class="badge bg-warning text-dark rounded-3">Sospeso</span>';
        $action_button = '<button class="btn btn-sm btn-outline-success rounded-3" onclick="publishPost(' . $post['id'] . ')">Pubblica</button>';
    } else {
        $status_badge = '<span class="badge bg-secondary rounded-3">Rimosso</span>';
        $action_button = '<button class="btn btn-sm btn-outline-secondary rounded-3" disabled>Rimosso</button>';
    }

    $rows .= <<<ROW
                    <tr>
                        <td><strong>{$post['title']}</strong></td>
                        <td>mrossi</td>
                        <td>{$post['course']}</td>
                        <td>{$post['publish_date']}</td>
                        <td>$status_badge</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-primary rounded-3">Visualizza</a>
                            $action_button
                        </td>
                    </tr>
ROW;
}

$adminContent = str_replace('PHP_TOTAL_POSTS', $total_posts, $adminContent);
$adminContent = str_replace('PHP_POSTS_ROWS', $rows, $adminContent);

$content = <<<HTML
$adminContent

<script>
function removePost(postId) {
    if (confirm('Sei sicuro di voler rimuovere questo post?')) {
        // Implementare la logica di rimozione
        console.log('Rimozione post:', postId);
    }
}

function publishPost(postId) {
    if (confirm('Sei sicuro di voler pubblicare questo post?')) {
        // Implementare la logica di pubblicazione
        console.log('Pubblicazione post:', postId);
    }
}
</script>
HTML;

include 'template/admin.php';
