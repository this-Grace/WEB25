<?php if ($post): ?>
<article class="card border-0 rounded-5 mb-4 bg-body-tertiary">
    <div class="card-body p-4 position-relative">
        <h2 class="card-title h5"><?= htmlspecialchars($post['title']) ?></h2>
        <div class="text-primary fw-semibold small">@<?= htmlspecialchars($post['user_username']) ?></div>
        <p class="mt-2"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        <ul class="list-unstyled mt-3 pt-3 border-top">
            <li class="py-1"><strong>Corso:</strong> <?= htmlspecialchars($post['degree_course']) ?></li>
            <li class="py-1"><strong>Team richiesto:</strong> <?= intval($post['num_collaborators']) ?> persone</li>
        </ul>
    </div>
</article>

<div class="actions d-flex justify-content-center gap-3 my-4">
    <!-- Skip -->
    <form method="POST" action="react.php">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <input type="hidden" name="type" value="skip">
        <button type="submit" aria-label="Skip" title="Skip"
            class="btn btn-outline-danger rounded-circle d-flex justify-content-center align-items-center"
            style="width: 60px; height: 60px; font-size: 1.5rem;">
            ×
        </button>
    </form>

    <!-- Like -->
    <form method="POST" action="react.php">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <input type="hidden" name="type" value="like">
        <button type="submit" aria-label="Like" title="Like"
            class="btn btn-outline-success rounded-circle d-flex justify-content-center align-items-center"
            style="width: 60px; height: 60px; font-size: 1.5rem;">
            ♥
        </button>
    </form>
</div>

<?php else: ?>
    <p class="text-center text-muted">Non ci sono più post disponibili al momento.</p>
<?php endif; ?>
