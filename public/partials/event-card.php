<?php
$isFull = (int)$event['total_seats'] > 0 && (int)$event['occupied_seats'] >= (int)$event['total_seats'];
$isSubscribed = false;
if (isset($_SESSION['user']['id']) && isset($templateParams['user_subscriptions'])) {
    $isSubscribed = in_array((int)$event['id'], array_map('intval', $templateParams['user_subscriptions']), true);
}
?>
<article class="col-lg-4 col-md-6 mb-4"
    data-event-id="<?= htmlspecialchars($event['id']) ?>"
    data-category-id="<?= htmlspecialchars($event['category_id']) ?>"
    data-user-id="<?= htmlspecialchars($event['user_id']) ?>">

    <div class="card event-card h-100 shadow-sm">
        <div class="position-relative">
            <img src="<?= EVENTS_IMG_DIR . htmlspecialchars($event['image']) ?>"
                class="card-img-top event-img <?= (new DateTime($event['event_date'])) < new DateTime('today') ? 'opacity-50 past-event' : '' ?>"
                alt="Locandina: <?= htmlspecialchars($event['title']) ?>" />

            <?php if ((new DateTime($event['event_date'])) < new DateTime('today')): ?>
                <div class="position-absolute top-50 start-50 translate-middle w-100 text-center">
                    <span class="badge bg-dark text-light px-4 py-2 fs-6">CONCLUSO</span>
                </div>
            <?php else: ?>
                <?php switch (strtolower($event['status'] ?? '')):
                    case 'waiting': ?>
                        <div class="position-absolute top-50 start-50 translate-middle w-100 text-center">
                            <span class="badge bg-warning text-dark px-4 py-2 fs-6">In Revisione</span>
                        </div>
                    <?php break;
                    case 'cancelled': ?>
                        <div class="position-absolute top-50 start-50 translate-middle w-100 text-center">
                            <span class="badge bg-danger text-light px-4 py-2 fs-6">ANNULLATO</span>
                        </div>
                    <?php break;
                endswitch; ?>
            <?php endif; ?>

            <span class="badge badge-cate-<?= strtolower(htmlspecialchars($event['category'] ?? 'generico')) ?> position-absolute top-0 start-0 m-3 shadow-sm">
                <?= htmlspecialchars($event['category'] ?? 'Evento') ?>
            </span>
        </div>

        <div class="card-body d-flex flex-column p-3">
            <h2 class="card-title h5 fw-bold mb-1"><?= htmlspecialchars($event['title']) ?></h2>
            <p class="preview-description small text-muted mb-2">
                <?= htmlspecialchars(mb_strlen($event['description']) > 100 ?
                    mb_substr($event['description'], 0, 100) . '...' :
                    $event['description']) ?>
            </p>

            <ul class="list-unstyled mb-2">
                <li class="mb-1 small text-muted">
                    <span class="bi bi-calendar3 text-primary me-2" aria-hidden="true"></span>
                    <?= (new DateTime($event['event_date']))->format('d/m/Y') ?> alle <?= htmlspecialchars($event['event_time']) ?>
                </li>
                <li class="mb-1 small text-muted">
                    <span class="bi bi-geo-alt text-success me-2" aria-hidden="true"></span>
                    <?= htmlspecialchars($event['location']) ?>
                </li>
                <li class="mb-1 small text-muted">
                    <span class="bi bi-people text-danger me-2" aria-hidden="true"></span>
                    <strong><?= (int)$event['occupied_seats'] ?> / <?= (int)$event['total_seats'] ?></strong> iscritti
                </li>
            </ul>

            <?php
            if ((new DateTime($event['event_date'])) >= new DateTime('today') && isset($_SESSION['user']['id'])):
                $isAdmin = (strtolower($_SESSION['user']['role']) === 'admin');
            ?>
                <div class="mt-auto pt-3">
                    <div class="d-flex flex-wrap gap-2">
                        <?php if ($_SESSION['user']['id'] == $event['user_id']): ?>
                            <div class="d-flex flex-column w-100 gap-2">
                                <?php if (strtolower($event['status']) === 'draft'): ?>
                                    <a href="api/edit_event.php?event_id=<?= $event['id'] ?>&action=publish_from_draft" class="btn btn-outline-success btn-sm w-100">
                                        <span class="bi bi-upload me-1"></span> Pubblica
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (in_array(strtolower($event['status']), ['draft', 'waiting', 'approved'])): ?>
                                    <div class="d-flex gap-2">
                                        <a href="event.php?event_id=<?= $event['id'] ?>" class="btn btn-outline-dark btn-sm flex-grow-1">
                                            <span class="bi bi-pencil me-1"></span> Modifica
                                        </a>
                                        <?php if (strtolower($event['status']) === 'draft'): ?>
                                            <a href="api/delete_event.php?event_id=<?= $event['id'] ?>"
                                                class="btn btn-outline-danger btn-sm flex-grow-1"
                                                onclick="return confirm('Sei sicuro di voler eliminare definitivamente questo evento?')">
                                                <span class="bi bi-trash me-1"></span> Elimina
                                            </a>
                                        <?php else: ?>
                                            <a href="api/cancel_event.php?event_id=<?= $event['id'] ?>"
                                                class="btn btn-outline-warning btn-sm flex-grow-1"
                                                onclick="return confirm('Sei sicuro di voler annullare questo evento?')">
                                                <span class="bi bi-x-circle me-1"></span> Annulla
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php elseif ($isAdmin && strtolower($event['status']) === 'waiting'): ?>
                            <a href="api/approve_event.php?event_id=<?= $event['id'] ?>" class="btn btn-success btn-sm flex-grow-1">
                                <span class="bi bi-check-circle me-1"></span> Approva Evento
                            </a>
                        <?php elseif (strtolower($event['status']) === 'approved'): ?>
                            <?php if ($isSubscribed): ?>
                                <a href="api/unsubscribe.php?event_id=<?= $event['id'] ?>" class="btn btn-danger btn-sm flex-grow-1">
                                    <span class="bi bi-person-dash me-1"></span> Disiscriviti
                                </a>
                            <?php elseif ($isFull): ?>
                                <button class="btn btn-secondary btn-sm flex-grow-1" disabled>
                                    <span class="bi bi-slash-circle me-1"></span> POSTI ESAURITI
                                </button>
                            <?php else: ?>
                                <a href="api/subscribe.php?event_id=<?= $event['id'] ?>" class="btn btn-primary btn-sm flex-grow-1">
                                    <span class="bi bi-person-plus me-1"></span> Iscriviti
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>