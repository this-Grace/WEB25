<?php
session_start();

require_once __DIR__ . '/../config/database.php';

// Gestione azioni POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['user_id'])) {
    $action = $_POST['action'];
    $userId = (int)$_POST['user_id'];

    try {
        global $dbh;
        $db = $dbh->getConnection();

        switch ($action) {
            case 'suspend':
                $stmt = $db->prepare("UPDATE users SET status = 'suspended' WHERE id = ?");
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $stmt->close();
                break;
            case 'restore':
                $stmt = $db->prepare("UPDATE users SET status = 'active' WHERE id = ?");
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $stmt->close();
                break;
            case 'delete':
                $stmt = $db->prepare("UPDATE users SET status = 'deleted' WHERE id = ?");
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $stmt->close();
                break;
        }

        header('Location: /admin-users.php?status=' . ($_GET['status'] ?? ''));
        exit;
    } catch (Exception $e) {
        // Errore nella gestione
    }
}

// Filtri
$statusFilter = $_GET['status'] ?? '';
$searchTerm = $_GET['search'] ?? '';

try {
    global $dbh;
    $db = $dbh->getConnection();

    // Query base
    $query = "SELECT u.id, CONCAT(u.name, ' ', u.surname) as name, u.email, 
              u.university, 
              DATE_FORMAT(u.created_at, '%Y-%m-%d') as joined, u.status
              FROM users u
              WHERE u.role != 'admin'";

    if (!empty($statusFilter)) {
        $query .= " AND u.status = '" . $db->real_escape_string($statusFilter) . "'";
    }

    if (!empty($searchTerm)) {
        $escaped = $db->real_escape_string($searchTerm);
        $query .= " AND (u.name LIKE '%{$escaped}%' OR u.surname LIKE '%{$escaped}%' OR u.email LIKE '%{$escaped}%')";
    }

    $query .= " ORDER BY u.created_at DESC LIMIT 50";

    $result = $db->query($query);
    $users = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
} catch (Exception $e) {
    $users = [];
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
        <form method="GET" class="d-flex gap-2">
            <input type="search" name="search" class="form-control form-control-sm" placeholder="Cerca utente..." style="max-width: 250px;" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <select name="status" class="form-select form-select-sm" style="max-width: 150px;" onchange="this.form.submit()">
                <option value="">Tutti gli stati</option>
                <option value="active" <?php echo $statusFilter === 'active' ? 'selected' : ''; ?>>Attivi</option>
                <option value="suspended" <?php echo $statusFilter === 'suspended' ? 'selected' : ''; ?>>Sospesi</option>
                <option value="deleted" <?php echo $statusFilter === 'deleted' ? 'selected' : ''; ?>>Eliminati</option>
            </select>
        </form>
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
                                <?php elseif ($user['status'] === 'suspended'): ?>
                                    <span class="badge bg-warning-subtle text-warning">Sospeso</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger">Eliminato</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="/profile.php?id=<?php echo $user['id']; ?>" class="btn btn-outline-primary" title="Visualizza">
                                        <span class="bi bi-eye" aria-hidden="true"></span>
                                    </a>
                                    <?php if ($user['status'] === 'active'): ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="suspend">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-outline-warning" title="Sospendi" onclick="return confirm('Sospendere questo utente?')">
                                                <span class="bi bi-pause-circle" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    <?php elseif ($user['status'] === 'suspended'): ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="restore">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-outline-success" title="Ripristina">
                                                <span class="bi bi-play-circle" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($user['status'] !== 'deleted'): ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-outline-danger" title="Elimina" onclick="return confirm('Eliminare definitivamente questo utente?')">
                                                <span class="bi bi-trash" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    <?php endif; ?>
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