<?php
// Expects $event array and optional $templateParams in scope
$userRole = $userRole ?? strtolower($_SESSION['user']['role'] ?? '');
$isLogged = !empty($_SESSION['user']['email']);
$sessionEmail = $_SESSION['user']['email'] ?? '';
$isOwner = ($sessionEmail !== '' && $sessionEmail === ($event['user_email'] ?? ''));
$userSubs = $templateParams['user_subscriptions'] ?? [];
$isSubscribed = !empty($userSubs) && in_array((int)($event['id'] ?? 0), array_map('intval', $userSubs), true);
$totalSeats = (int)($event['total_seats'] ?? 0);
$occupiedSeats = (int)($event['occupied_seats'] ?? 0);
$isFull = ($totalSeats > 0 && $occupiedSeats >= $totalSeats);
$status = strtolower($event['status'] ?? '');
?>
<article class="col-lg-4 col-md-6 mb-4"
    data-event-id="<?= htmlspecialchars($event["id"], ENT_QUOTES, 'UTF-8') ?>"
    data-category-id="<?= htmlspecialchars($event["category_id"], ENT_QUOTES, 'UTF-8') ?>"
    data-user-email="<?= htmlspecialchars($event["user_email"], ENT_QUOTES, 'UTF-8') ?>"
    data-status="<?= strtolower($event["status"] ?? '') ?>">

    <div class="card event-card h-100">
        <div class="position-relative">
            <img src="<?= EVENTS_IMG_DIR . htmlspecialchars($event["image"], ENT_QUOTES, 'UTF-8') ?>"
                class="card-img-top"
                alt="Immagine relativa all'evento: <?= htmlspecialchars($event["title"], ENT_QUOTES, 'UTF-8') ?>"
                loading="lazy">
            <span class="badge badge-cate-<?= strtolower(htmlspecialchars($event["category"], ENT_QUOTES, 'UTF-8')) ?> position-absolute top-0 start-0 m-3">
                <?= htmlspecialchars($event["category"], ENT_QUOTES, 'UTF-8') ?>
            </span>
        </div>

        <div class="card-body d-flex flex-column">
            <h3 class="card-title"><?= htmlspecialchars($event["title"], ENT_QUOTES, 'UTF-8') ?></h3>
            <p class="preview-description small text-muted mb-2"><?= htmlspecialchars($event['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>

            <p class="card-text text-muted small flex-grow-1">
                <span class="bi bi-calendar text-primary" aria-hidden="true"></span>
                <?= htmlspecialchars($event['event_date'] ?? '', ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($event['event_time'] ?? '', ENT_QUOTES, 'UTF-8') ?><br>

                <span class="bi bi-geo-alt text-success" aria-hidden="true"></span>
                <?= htmlspecialchars($event['location'] ?? '', ENT_QUOTES, 'UTF-8') ?><br>

                <span class="bi bi-people text-danger" aria-hidden="true"></span>
                <?= $occupiedSeats ?>/<?= $totalSeats ?> iscritti
            </p>

            <?php if ($status === 'cancelled'): ?>
                <a class="btn btn-warning w-100 mt-auto disabled d-flex align-items-center justify-content-center mb-1">
                    <em class="bi bi-slash-circle" aria-hidden="true"></em>
                    <span class="ms-2 d-md-inline">Annullato</span>
                </a>
            <?php else: ?>
                <?php if ($isFull): ?>
                    <a class="btn btn-secondary w-100 mt-auto disabled d-flex align-items-center justify-content-center mb-1">
                        <em class="bi bi-x-octagon" aria-hidden="true"></em>
                        <span class="ms-2 d-md-inline">Evento pieno</span>
                    </a>
                <?php endif; ?>
                <?php if ($isLogged && $status === 'approved'): ?>
                    <?php if (!$isOwner && !$isSubscribed && !$isFull): ?>
                        <a href="api/subscribe.php?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-dark w-100 mt-auto d-flex align-items-center justify-content-center mb-1">
                            <em class="bi bi-person-plus" aria-hidden="true"></em>
                            <span class="ms-2 d-md-inline">Iscriviti all'evento</span>
                        </a>
                    <?php elseif (!$isOwner && $isSubscribed): ?>
                        <a href="api/unsubscribe.php?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-danger w-100 mt-auto d-flex align-items-center justify-content-center mb-1">
                            <em class="bi bi-person-x" aria-hidden="true"></em>
                            <span class="ms-2 d-md-inline">Disiscriviti</span>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($userRole === 'admin' && $status === 'waiting'): ?>
                    <div class="d-flex gap-2 w-100 align-items-stretch mb-1">
                        <a href="api/approve_event.php?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-success d-flex align-items-center justify-content-center flex-fill col-6">
                            <em class="bi bi-check2-circle" aria-hidden="true"></em>
                            <span class="ms-2 d-md-inline">Approva</span>
                        </a>
                        <a href="api/delete_event.php?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-outline-danger d-flex align-items-center justify-content-center flex-fill col-6">
                            <em class="bi bi-trash" aria-hidden="true"></em>
                            <span class="ms-2 d-md-inline">Cancella</span>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ($isOwner): ?>
                    <div class="d-flex gap-2 w-100 align-items-stretch mb-1">
                        <a href="api/edit_event.php?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-outline-primary d-flex align-items-center justify-content-center flex-fill col-6">
                            <em class="bi bi-pencil" aria-hidden="true"></em>
                            <span class="ms-2 d-md-inline">Modifica</span>
                        </a>
                        <a href="api/cancel_event.php?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-warning d-flex align-items-center justify-content-center flex-fill col-6">
                            <em class="bi bi-x-circle" aria-hidden="true"></em>
                            <span class="ms-2 d-md-inline">Annulla</span>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</article>