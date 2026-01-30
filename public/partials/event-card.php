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
                <div class="position-absolute top-50 start-50 translate-middle w-100 text-center z-1">
                    <span class="badge text-dark px-4 py-2 fs-6">CONCLUSO</span>
                </div>
            <?php else: ?>
                <?php switch (strtolower($event['status'] ?? '')):
                    case 'waiting': ?>
                        <div class="position-absolute top-50 start-50 translate-middle w-100 text-center z-1">
                            <span class="badge bg-warning text-dark px-4 py-2 fs-6">In Revisione</span>
                        </div>
                    <?php break;
                    case 'cancelled': ?>
                        <div class="position-absolute top-50 start-50 translate-middle w-100 text-center z-1">
                            <span class="badge bg-danger text-light px-4 py-2 fs-6">Annullato</span>
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

            <?php if ((int)$event['total_seats'] > 0 && (int)$event['occupied_seats'] >= (int)$event['total_seats']): ?>
                <div class="mt-auto pt-2">
                    <span class="badge bg-secondary w-100 py-2">POSTI ESAURITI</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>