<?php
$isPast = new DateTime($event['event_date']) < new DateTime('today');
$isOwner = ($_SESSION['user']['email'] ?? '') == $event['user_email'];
$status = strtolower($event['status'] ?? '');

$isSubscribed = false;
if (isset($templateParams['user_subscriptions']) && is_array($templateParams['user_subscriptions'])) {
    $isSubscribed = in_array($event['id'], $templateParams['user_subscriptions']);
}
?>

<article class="col-lg-4 col-md-6 mb-4"
    data-event-id="<?= htmlspecialchars($event['id']) ?>"
    data-category-id="<?= htmlspecialchars($event['category_id']) ?>"
    data-user-email="<?= htmlspecialchars($event['user_email']) ?>"
    data-status="<?= $status ?>">

    <div class="card event-card h-100 shadow-sm border-0">
        <div class="position-relative">
            <img src="<?= EVENTS_IMG_DIR . htmlspecialchars($event['image']) ?>"
                class="card-img-top <?= $isPast ? 'opacity-50' : '' ?>"
                alt="Locandina: <?= htmlspecialchars($event['title']) ?>"/>

            <?php if ($isPast): ?>
                <div class="position-absolute top-50 start-50 translate-middle w-100 text-center z-1">
                    <span class="badge bg-dark px-4 py-2 fs-6">CONCLUSO</span>
                </div>
            <?php elseif ($status == 'waiting' && $isOwner): ?>
                <div class="position-absolute top-50 start-50 translate-middle w-100 text-center z-1">
                    <span class="badge bg-warning text-dark px-4 py-2 fs-6">In Revisione</span>
                </div>
            <?php endif; ?>

            <span class="badge badge-cate-<?= strtolower(htmlspecialchars($event['category'] ?? 'generico')) ?> position-absolute top-0 start-0 m-3 shadow-sm">
                <?= htmlspecialchars($event['category'] ?? 'Evento') ?>
            </span>
        </div>

        <div class="card-body d-flex flex-column p-3">
            <h2 class="card-title h5 fw-bold mb-1"><?= htmlspecialchars($event['title']) ?></h2>

            <div class="mb-1 small text-muted">
                <span class="bi bi-calendar3 text-primary me-2" aria-hidden="true"></span>
                <?= (new DateTime($event['event_date']))->format('d/m/Y') ?> alle <?= htmlspecialchars($event['event_time']) ?>
            </div>
            <div class="mb-3 small text-muted">
                <span class="bi bi-people text-danger me-2" aria-hidden="true"></span>
                <strong><?= (int)$event['occupied_seats'] ?> / <?= (int)$event['total_seats'] ?></strong> iscritti
            </div>

            <?php if (!$isPast && isset($_SESSION['user']['email'])): ?>
                <div class="mt-auto d-grid gap-2">
                    <?php if (strtolower($_SESSION['user']['role'] ?? '') == 'admin' && $status == 'waiting'): ?>
                        <a href="api/approve_event.php?event_id=<?= $event['id'] ?>" class="btn btn-success btn-sm mb-2 shadow-sm">
                            <span class="bi bi-check-circle me-1" aria-hidden="true"></span> Approva Evento
                        </a>
                    <?php endif; ?>

                    <?php if ($isOwner): ?>
                        <div class="d-flex gap-2">
                            <?php if ($status == 'draft'): ?>
                                <a href="api/edit_event.php?event_id=<?= $event['id'] ?>" class="btn btn-outline-success flex-grow-1 btn-sm">
                                    <span class="bi bi-send-fill" aria-hidden="true"></span> Pubblica
                                </a>
                            <?php endif; ?>
                            <a href="api/edit_event.php?event_id=<?= $event['id'] ?>" class="btn btn-outline-dark flex-grow-1 btn-sm">
                                <span class="bi bi-pencil" aria-hidden="true"></span> Modifica
                            </a>
                            <a href="api/delete_event.php?event_id=<?= $event['id'] ?>" class="btn btn-outline-danger flex-grow-1 btn-sm" onclick="return confirm('Sicuro di eliminare l\'evento?')">
                                <span class="bi bi-trash" aria-hidden="true"></span> Elimina
                            </a>
                        </div>
                    <?php elseif ($status == 'approved' || $status == 'active'): ?>
                        <?php if ($isSubscribed): ?>
                            <a href="api/unsubscribe.php?event_id=<?= $event['id'] ?>" class="btn btn-danger shadow-sm">
                                <span class="bi bi-person-x me-1" aria-hidden="true"></span> Disiscrivimi
                            </a>
                        <?php elseif ($event['occupied_seats'] >= $event['total_seats']): ?>
                            <span class="btn btn-secondary disabled">
                                <span class="bi bi-x-octagon me-1" aria-hidden="true"></span> Evento Pieno
                            </span>
                        <?php else: ?>
                            <a href="api/subscribe.php?event_id=<?= $event['id'] ?>" class="btn btn-dark shadow-sm">
                                <span class="bi bi-person-plus me-1" aria-hidden="true"></span> Iscriviti
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>