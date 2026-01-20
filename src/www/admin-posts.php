<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Post.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['post_id'])) {
    $action = $_POST['action'];
    $postId = (int)$_POST['post_id'];

    try {
        $postModel = new Post();

        switch ($action) {
            case 'hide':
                $postModel->changeStatus($postId, 'hidden');
                break;
            case 'publish':
                $postModel->changeStatus($postId, 'published');
                break;
            case 'delete':
                $postModel->delete($postId);
                break;
        }

        header('Location: /admin-posts.php?status=' . $_GET['status'] ?? '');
        exit;
    } catch (Exception $e) {
        // Errore nella gestione
    }
}

$statusFilter = $_GET['status'] ?? '';
$searchTerm = $_GET['search'] ?? '';

try {
    $postModel = new Post();
    $posts = $postModel->all($statusFilter, $searchTerm, 50);
} catch (Exception $e) {
    $posts = [];
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
        <form method="GET" class="d-flex gap-2">
            <input type="search" name="search" class="form-control form-control-sm" placeholder="Cerca post..." style="max-width: 250px;" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <select name="status" class="form-select form-select-sm" style="max-width: 150px;" onchange="this.form.submit()">
                <option value="">Tutti gli stati</option>
                <option value="published" <?php echo $statusFilter === 'published' ? 'selected' : ''; ?>>Pubblicati</option>
                <option value="hidden" <?php echo $statusFilter === 'hidden' ? 'selected' : ''; ?>>Nascosti</option>
                <option value="closed" <?php echo $statusFilter === 'closed' ? 'selected' : ''; ?>>Chiusi</option>
            </select>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Autore</th>
                        <th scope="col">Titolo</th>
                        <th scope="col">Data</th>
                        <th scope="col">Like</th>
                        <th scope="col">Skip</th>
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
                                    <?php echo htmlspecialchars($post['title']); ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                            <td>
                                <span class="bi bi-heart-fill text-danger me-1" aria-hidden="true"></span>
                                <?php echo htmlspecialchars($post['likes_count']); ?>
                            </td>
                            <td>
                                <span class="bi bi-skip-forward-fill text-warning me-1" aria-hidden="true"></span>
                                <?php echo htmlspecialchars($post['skips_count']); ?>
                            </td>
                            <td>
                                <?php if ($post['status'] === 'published'): ?>
                                    <span class="badge bg-success-subtle text-success">Pubblicato</span>
                                <?php elseif ($post['status'] === 'hidden'): ?>
                                    <span class="badge bg-warning-subtle text-warning">Nascosto</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary">Chiuso</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="/post-detail.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-primary" title="Visualizza">
                                        <span class="bi bi-eye" aria-hidden="true"></span>
                                    </a>
                                    <?php if ($post['status'] === 'published'): ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="hide">
                                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                            <button type="submit" class="btn btn-outline-warning" title="Nascondi" onclick="return confirm('Nascondere questo post?')">
                                                <span class="bi bi-eye-slash" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="publish">
                                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                            <button type="submit" class="btn btn-outline-success" title="Ripubblica">
                                                <span class="bi bi-eye" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                        <button type="submit" class="btn btn-outline-danger" title="Elimina" onclick="return confirm('Eliminare definitivamente questo post?')">
                                            <span class="bi bi-trash" aria-hidden="true"></span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$templateParams['userContent'] = ob_get_clean();

require_once 'template/admin-base.php';
?>