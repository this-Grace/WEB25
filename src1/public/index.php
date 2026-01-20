<?php

/**
 * Home Controller
 * Displays the main home page with user information and next available post.
 */

require_once __DIR__ . '/../app/User.php';
require_once __DIR__ . '/../app/Post.php';

session_start();

$username = $_SESSION['username'] ?? null;
$user = $username ? (new User())->find($username) : null;
$post = $user ? (new Post())->nextPost($user['username']) : null;

$pageTitle = "Home";

ob_start();
?>

<!-- Container per i post -->
<div id="posts-container">
    <?php if ($post): ?>
        <!-- Post attuale -->
        <div class="post-card" id="current-post" data-post-id="<?= $post['id'] ?>">
            <div class="card border-0 rounded-5 mb-4 bg-body-tertiary">
                <div class="card-body p-4">
                    <h2 id="post-title" class="card-title h5">
                        <?= htmlspecialchars($post['title']) ?>
                    </h2>

                    <div id="post-user" class="text-primary fw-semibold small">
                        @<?= htmlspecialchars($post['user_username']) ?>
                    </div>

                    <p id="post-content" class="mt-2">
                        <?= nl2br(htmlspecialchars($post['content'])) ?>
                    </p>

                    <ul class="list-unstyled mt-3 pt-3 border-top">
                        <li class="py-1">
                            <strong>Corso:</strong>
                            <span id="post-course">
                                <?= htmlspecialchars($post['degree_course'] ?? 'Non specificato') ?>
                            </span>
                        </li>

                        <li class="py-1">
                            <strong>Team richiesto:</strong>
                            <span id="post-team"><?= intval($post['num_collaborators']) ?></span> persone
                        </li>

                        <?php if (!empty($post['skills_required'])): ?>
                            <li class="py-1">
                                <strong>Competenze richieste:</strong>
                                <span id="post-skills"><?= htmlspecialchars($post['skills_required']) ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Nessun post disponibile -->
        <div id="no-posts" class="text-center text-muted py-5">
            <div class="mb-3">
                <i class="bi bi-emoji-frown" style="font-size: 3rem;"></i>
            </div>
            <h4 class="mb-2">Non ci sono più post disponibili</h4>
            <p class="text-muted">Torna più tardi per vedere nuovi contenuti!</p>
        </div>
    <?php endif; ?>
</div>

<!-- Bottoni di reazione -->
<?php if ($post): ?>
    <div class="d-flex justify-content-center gap-3 my-4" id="reaction-buttons">
        <button type="button" class="btn btn-outline-danger rounded-circle skip-btn"
            data-post-id="<?= $post['id'] ?>"
            style="width: 60px; height: 60px; font-size: 1.5rem;"
            aria-label="Skip" title="Skip">
            ×
        </button>

        <button type="button" class="btn btn-outline-success rounded-circle like-btn"
            data-post-id="<?= $post['id'] ?>"
            style="width: 60px; height: 60px; font-size: 1.5rem;"
            aria-label="Like" title="Like">
            ♥
        </button>
    </div>

    <template id="no-posts-template">
        <div id="no-posts" class="text-center text-muted py-5">
            <div class="mb-3">
                <i class="bi bi-emoji-frown" style="font-size: 3rem;"></i>
            </div>
            <h4 class="mb-2">Non ci sono più post disponibili</h4>
            <p class="text-muted">Torna più tardi per vedere nuovi contenuti!</p>
        </div>
    </template>

<?php endif; ?>

<script src="assets/js/react.js" defer></script>

<?php
$content = ob_get_clean();
include 'template/user.php';
?>