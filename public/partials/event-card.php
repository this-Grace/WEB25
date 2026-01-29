<?php
$totalSeats    = (int)($event['total_seats'] ?? 0);
$occupiedSeats = (int)($event['occupied_seats'] ?? 0);
$percentage    = ($totalSeats > 0) ? ($occupiedSeats / $totalSeats) * 100 : 0;
$isFull        = ($totalSeats > 0 && $occupiedSeats >= $totalSeats);

$status      = strtoupper($event['status'] ?? 'DRAFT');
$eventDateTimeStr = ($event['event_date'] ?? 'now') . ' ' . ($event['event_time'] ?? '00:00:00');
$eventTimestamp   = strtotime($eventDateTimeStr);

$isPast = (time() > $eventTimestamp);
$isCancelled = ($status === 'CANCELLED');
$tabContext  = $tabId ?? 'public';

if ($tabContext === 'organized-pane' && $isPast) return;

if ($tabContext === 'history-pane' && !$isPast) return;

$isLogged     = !empty($_SESSION['user']['email']);
$sessionEmail = $_SESSION['user']['email'] ?? '';
$isOwner      = ($sessionEmail !== '' && $sessionEmail === ($event['user_email'] ?? ''));
$userRole     = strtolower($_SESSION['user']['role'] ?? '');
$isAdmin      = ($userRole === 'admin');

$userSubs     = $templateParams['user_subscriptions'] ?? [];
$isSubscribed = in_array((int)($event['id'] ?? 0), array_map('intval', $userSubs), true);

$canEdit    = $isOwner && !$isPast && !$isCancelled;
$canCancel  = $isOwner && !$isCancelled && !$isPast && ($status === 'APPROVED');
$canDelete  = ($isOwner && ($status === 'DRAFT' || $status === 'WAITING')) || $isAdmin;
$canPublish = $isOwner && $status === 'DRAFT' && !$isPast;
$canApprove = $isAdmin && $status === 'WAITING';

$cleanTitle = htmlspecialchars($event["title"] ?? 'Evento senza titolo', ENT_QUOTES, 'UTF-8');
$imageName  = (!empty($event["image"])) ? $event["image"] : 'photo1.jpeg';
$img        = EVENTS_IMG_DIR . htmlspecialchars(basename($imageName), ENT_QUOTES, 'UTF-8');
?>

<article class="card event-card h-100 shadow-sm border-0 rounded-4 overflow-hidden <?= ($isPast || $isCancelled) ? 'opacity-75' : '' ?>"
    data-event-id="<?= htmlspecialchars($event["id"] ?? '', ENT_QUOTES, 'UTF-8') ?>"
    data-category-id="<?= htmlspecialchars($event["category_id"] ?? '', ENT_QUOTES, 'UTF-8') ?>"
    data-status="<?= strtolower($status) ?>">

    <div class="position-relative">
        <img src="<?= $img ?>" class="card-img-top"
            style="height: 200px; object-fit: cover;"
            alt="Immagine relativa all'evento: <?= $cleanTitle ?>"
            loading="lazy"
            onerror="this.onerror=null;this.src='<?= EVENTS_IMG_DIR ?>photo1.jpg';">

        <span class="badge badge-cate-<?= strtolower(htmlspecialchars($event["category"] ?? 'default', ENT_QUOTES, 'UTF-8')) ?> position-absolute top-0 start-0 m-3">
            <?= htmlspecialchars($event["category"] ?? 'Evento', ENT_QUOTES, 'UTF-8') ?>
        </span>

        <?php if ($isCancelled || $isPast): ?>
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center <?= $isCancelled ? 'bg-danger' : 'bg-dark' ?> bg-opacity-25">
                <span class="badge <?= $isCancelled ? 'bg-danger' : 'bg-dark' ?> shadow-sm"><?= $isCancelled ? 'ANNULLATO' : 'CONCLUSO' ?></span>
            </div>
        <?php endif; ?>
    </div>

    <div class="card-body d-flex flex-column p-3">
        <h2 class="h6 card-title fw-bold mb-2"><?= $cleanTitle ?></h2>

        <div class="card-text text-muted small mb-3">
            <div class="mb-1">
                <span class="bi bi-calendar-event text-primary me-2" aria-hidden="true"></span>
                <?= date('d/m/Y', strtotime($event['event_date'] ?? 'now')) ?> alle <?= htmlspecialchars($event['event_time'] ?? '00:00') ?>
            </div>
            <div class="mb-1">
                <span class="bi bi-geo-alt text-success me-2" aria-hidden="true"></span>
                <?= htmlspecialchars($event['location'] ?? 'TBD') ?>
            </div>
            <div class="mb-1">
                <span class="bi bi-people text-danger me-2" aria-hidden="true"></span>
                <?= $occupiedSeats ?>/<?= $totalSeats ?> iscritti
            </div>
        </div>

        <?php if (in_array($tabContext, ['organized-pane', 'draft-pane']) && !$isPast && !$isCancelled): ?>
            <div class="mb-3">
                <?php if ($status === 'APPROVED'): ?>
                    <div class="d-flex justify-content-between mb-1 text-muted" style="font-size: 0.7rem;">
                        <span>Capacità: <?= $occupiedSeats ?>/<?= $totalSeats ?></span>
                        <span class="fw-bold"><?= round($percentage) ?>%</span>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="<?= round($percentage) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                <?php elseif ($status === 'WAITING'): ?>
                    <div class="text-warning small d-flex align-items-center">
                        <span class="bi bi-clock-history me-2"></span>
                        <em>In attesa di revisione...</em>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="mt-auto pt-2 border-top">

            <?php if ($isCancelled): ?>
                <button class="btn btn-warning btn-sm w-100 disabled rounded-3 fw-bold">
                    <span class="bi bi-slash-circle me-2"></span> Annullato
                </button>

            <?php elseif ($tabContext === 'subscriber-pane' || ($tabContext === 'public' && $isSubscribed)): ?>
                <a href="api/unsubscribe.php?event_id=<?= $event['id'] ?>" class="btn btn-danger btn-sm w-100 rounded-3 fw-bold d-flex align-items-center justify-content-center" onclick="return confirm('Vuoi annullare la tua iscrizione?')">
                    <em class="bi bi-person-x me-2" aria-hidden="true"></em> Disiscriviti
                </a>

            <?php elseif ($tabContext === 'public' && $isLogged && $isOwner): ?>
                <a href="profile.php" class="btn btn-primary btn-sm w-100 rounded-3 fw-bold d-flex align-items-center justify-content-center">
                    <em class="bi bi-gear me-2"></em> Gestisci
                </a>

            <?php elseif ($tabContext === 'public' && $isLogged && !$isOwner): ?>
                <?php if ($isFull): ?>
                    <button class="btn btn-secondary btn-sm w-100 disabled rounded-3 fw-bold">
                        <em class="bi bi-x-octagon me-2"></em> Evento Pieno
                    </button>
                <?php elseif ($status === 'APPROVED'): ?>
                    <a href="api/subscribe.php?event_id=<?= $event['id'] ?>" class="btn btn-dark btn-sm w-100 rounded-3 fw-bold d-flex align-items-center justify-content-center">
                        <em class="bi bi-person-plus me-2"></em> Iscriviti
                    </a>
                <?php endif; ?>

            <?php elseif ($isOwner || $isAdmin): ?>
                <div class="d-flex flex-wrap gap-2">
                    <?php if ($canPublish): ?>
                        <form action="api/edit_event.php?event_id=<?= $event['id'] ?>" method="POST" class="flex-fill">
                            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                            <input type="hidden" name="title" value="<?= htmlspecialchars($event['title'] ?? '') ?>">
                            <input type="hidden" name="description" value="<?= htmlspecialchars($event['description'] ?? '') ?>">
                            <input type="hidden" name="event_date" value="<?= $event['event_date'] ?? '' ?>">
                            <?php
                            $timeParts = explode(':', $event['event_time'] ?? '00:00');
                            $hour = $timeParts[0] ?? '00';
                            $min  = $timeParts[1] ?? '00';
                            ?>
                            <input type="hidden" name="event_time_hour" value="<?= $hour ?>">
                            <input type="hidden" name="event_time_minute" value="<?= $min ?>">
                            <input type="hidden" name="location" value="<?= htmlspecialchars($event['location'] ?? '') ?>">
                            <input type="hidden" name="category_id" value="<?= $event['category_id'] ?? 0 ?>">
                            <input type="hidden" name="max_seats" value="<?= $event['total_seats'] ?? 0 ?>">
                            <input type="hidden" name="publish_from_draft" value="1">

                            <button type="submit" class="btn btn-outline-success btn-sm w-100 shadow-sm fw-bold">
                                <span class="bi bi-send me-1"></span> Pubblica
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if ($canApprove): ?>
                        <a href="api/approve_event.php?event_id=<?= $event['id'] ?>" class="btn btn-success btn-sm flex-fill fw-bold d-flex align-items-center justify-content-center">
                            <span class="bi bi-check2-circle me-1"></span> Approva
                        </a>
                    <?php endif; ?>

                    <?php if ($canEdit): ?>
                        <a href="event.php?event_id=<?= $event['id'] ?>" class="btn btn-outline-dark btn-sm flex-fill text-center">
                            <span class="bi bi-pencil" aria-hidden="true"></span> Modifica
                        </a>
                    <?php endif; ?>

                    <div class="d-flex gap-2 w-100 mt-1">
                        <?php if ($canCancel): ?>
                            <a href="api/cancel_event.php?event_id=<?= $event['id'] ?>" class="btn btn-warning btn-sm flex-fill fw-bold text-center text-dark" onclick="return confirm('Annullare l\'evento?')">
                                <span class="bi bi-x-circle"></span> Annulla
                            </a>
                        <?php endif; ?>

                        <?php if ($canDelete): ?>
                            <a href="api/delete_event.php?event_id=<?= $event['id'] ?>" class="btn btn-danger btn-sm flex-fill text-center" onclick="return confirm('Eliminare l\'evento?')">
                                <span class="bi bi-trash"></span> Elimina
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>