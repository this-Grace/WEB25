<?php
session_start();

// TODO: proteggere questa pagina con controllo ruolo admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: /login.php');
//     exit;
// }

// Dati fittizi di esempio
$posts = [
    ['id' => 1, 'author' => 'Giulia Rossi', 'content' => 'Cerco qualcuno per progetto di programmazione web...', 'created' => '2026-01-06 14:32', 'likes' => 12, 'comments' => 5, 'status' => 'published'],
    ['id' => 2, 'author' => 'Luca Bianchi', 'content' => 'Qualcuno sa dove trovare dispense di matematica?', 'created' => '2026-01-06 11:20', 'likes' => 8, 'comments' => 3, 'status' => 'published'],
    ['id' => 3, 'author' => 'Sara Verdi', 'content' => 'Gruppo studio per esame di fisica cercasi!', 'created' => '2026-01-05 16:45', 'likes' => 15, 'comments' => 7, 'status' => 'published'],
    ['id' => 4, 'author' => 'Marco Neri', 'content' => 'Contenuto inappropriato segnalato...', 'created' => '2026-01-05 09:12', 'likes' => 2, 'comments' => 1, 'status' => 'hidden'],
    ['id' => 5, 'author' => 'Anna Blu', 'content' => 'Chi ha informazioni sul corso di web design?', 'created' => '2026-01-04 18:30', 'likes' => 10, 'comments' => 4, 'status' => 'published'],
];

// TODO: Implementare azioni (nascondi, elimina, ripristina)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $postId = $_POST['post_id'] ?? 0;

    // Placeholder per gestione azioni
    // switch($action) {
    //     case 'hide': ...
    //     case 'delete': ...
    //     case 'restore': ...
    // }
}

$templateParams['pageTitle'] = 'Gestione Post';

ob_start();
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Gestione Post</h1>
        <p class="text-muted mb-0">Visualizza e modera tutti i post pubblicati</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="window.print()">
            <span class="bi bi-printer me-2" aria-hidden="true"></span>Stampa
        </button>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-body border-0 d-flex align-items-center justify-content-between">
        <h2 class="h6 mb-0">Elenco post (<?php echo count($posts); ?>)</h2>
        <div class="d-flex gap-2">
            <input type="search" class="form-control form-control-sm" placeholder="Cerca post..." style="max-width: 250px;">
            <select class="form-select form-select-sm" style="max-width: 150px;">
                <option value="">Tutti gli stati</option>
                <option value="published">Pubblicati</option>
                <option value="hidden">Nascosti</option>
            </select>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Autore</th>
                        <th scope="col">Contenuto</th>
                        <th scope="col">Data</th>
                        <th scope="col">Like</th>
                        <th scope="col">Commenti</th>
                        <th scope="col">Stato</th>
                        <th scope="col" class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($post['id']); ?></td>
                            <td class="fw-semibold"><?php echo htmlspecialchars($post['author']); ?></td>
                            <td>
                                <div class="text-truncate" style="max-width: 300px;">
                                    <?php echo htmlspecialchars($post['content']); ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($post['created']); ?></td>
                            <td>
                                <span class="bi bi-heart-fill text-danger me-1" aria-hidden="true"></span>
                                <?php echo htmlspecialchars($post['likes']); ?>
                            </td>
                            <td>
                                <span class="bi bi-chat-fill text-primary me-1" aria-hidden="true"></span>
                                <?php echo htmlspecialchars($post['comments']); ?>
                            </td>
                            <td>
                                <?php if ($post['status'] === 'published'): ?>
                                    <span class="badge bg-success-subtle text-success">Pubblicato</span>
                                <?php else: ?>
                                    <span class="badge bg-warning-subtle text-warning">Nascosto</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="Visualizza">
                                        <span class="bi bi-eye" aria-hidden="true"></span>
                                    </button>
                                    <?php if ($post['status'] === 'published'): ?>
                                        <button class="btn btn-outline-warning" title="Nascondi">
                                            <span class="bi bi-eye-slash" aria-hidden="true"></span>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-outline-success" title="Ripubblica">
                                            <span class="bi bi-eye" aria-hidden="true"></span>
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
            <span class="text-muted small">Mostrando <?php echo count($posts); ?> di <?php echo count($posts); ?> post</span>
            <nav aria-label="Paginazione post">
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