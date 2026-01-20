<?php
$pageTitle  = 'Crea Post';

session_start();
require_once __DIR__ . '/../app/Post.php';
require_once __DIR__ . '/../app/User.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['description'] ?? '');
    $numCollaborators = (int)($_POST['num_people'] ?? 2);
    $skillsRequired = trim($_POST['skills'] ?? '');
    $username = $_SESSION['username'];

    if (empty($title) || empty($content) || $numCollaborators < 1) {
        $message = 'Compila tutti i campi obbligatori';
        $messageType = 'danger';
    } else {
        try {
            $userModel = new User();
            $user = $userModel->find($username);

            if (!$user) {
                $message = 'Errore: utente non trovato';
                $messageType = 'danger';
            } elseif (empty($user['faculty_id'])) {
                $message = 'Devi completare il tuo profilo con la facoltà prima di creare un post';
                $messageType = 'warning';
            } else {
                $postModel = new Post();

                $postId = $postModel->create(
                    $username,
                    $title,
                    $content,
                    $numCollaborators,
                    !empty($skillsRequired) ? $skillsRequired : null
                );

                if ($postId) {
                    $message = 'Post creato con successo!';
                    $messageType = 'success';
                    header('Refresh: 2; url=index.php');
                } else {
                    $message = 'Errore nella creazione del post';
                    $messageType = 'danger';
                }
            }
        } catch (Exception $e) {
            error_log('Create Post Error: ' . $e->getMessage());
            $message = 'Errore durante la creazione del post';
            $messageType = 'danger';
        }
    }
}

ob_start();
?>

<div class="row justify-content-center w-100">
    <div class="col-12 col-md-10 col-lg-8 col-xl-7">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4 p-md-5">
                <h1 class="h3 mb-4 text-center">Crea nuovo post</h1>
                <form method="post" novalidate>
                    <!-- Titolo -->
                    <div class="mb-3">
                        <input type="text"
                            class="form-control"
                            id="title"
                            name="title"
                            placeholder="Titolo"
                            required>
                    </div>
                    <!-- Descrizione -->
                    <div class="mb-3">
                        <textarea class="form-control" id="description"
                            name="description" rows="5"
                            placeholder="Descrizione del progetto"
                            required></textarea>
                    </div>
                    <!-- Numero persone richieste -->
                    <div class="mb-3">
                        <input type="number"
                            class="form-control"
                            id="num-people"
                            name="num_people"
                            min="1"
                            max="10"
                            placeholder="Persone necessarie"
                            value="2"
                            required>
                    </div>
                    <!-- Skill -->
                    <div class="mb-3">
                        <textarea class="form-control"
                            id="skills"
                            name="skills"
                            rows="3"
                            placeholder="Skill richieste (opzionale)"></textarea>
                    </div>
                    <button type="submit"
                        class="btn btn-primary w-100 mb-3">
                        Pubblica post
                    </button>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?php echo $messageType; ?> rounded-4 mb-0" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/template/user.php';
?>