<?php
$totalSeats    = (int)($event['total_seats'] ?? 0);
$occupiedSeats = (int)($event['occupied_seats'] ?? 0);
$percentage    = ($totalSeats > 0) ? ($occupiedSeats / $totalSeats) * 100 : 0;

$status      = strtoupper($event['status'] ?? 'DRAFT');
$isPast      = strtotime($event['event_date'] ?? 'now') < time();
$isCancelled = ($status === 'CANCELLED');
$tabContext  = $tabId ?? 'public';

$isOwner   = (($_SESSION['user']['email'] ?? '') === ($event['user_email'] ?? ''));
$userRole  = strtolower($templateParams['user_role'] ?? $_SESSION['user']['role'] ?? 'guest');
$isAdmin   = ($userRole === 'admin');

$canEdit    = $isOwner && !$isPast && !$isCancelled;
$canCancel  = $isOwner && !$isCancelled && !$isPast && ($status === 'APPROVED');
$canDelete  = ($isOwner && ($status === 'DRAFT' || $status === 'WAITING')) || $isAdmin;
$canPublish = $isOwner && $status === 'DRAFT' && !$isPast;

$cleanTitle   = htmlspecialchars($event["title"] ?? 'Evento senza titolo', ENT_QUOTES, 'UTF-8');
$img = EVENTS_IMG_DIR . htmlspecialchars($event["image"] ?? 'default.jpg', ENT_QUOTES, 'UTF-8')
?>

<article class="card event-card h-100 shadow-sm border-0 rounded-4 overflow-hidden <?= ($isPast || $isCancelled) ? 'opacity-75' : '' ?>">
    <div class="position-relative">
        <img src="<?= $img ?>" class="card-img-top"
            alt="Immagine relativa all'evento: <?= htmlspecialchars($event["title"], ENT_QUOTES, 'UTF-8') ?>"
            loading="lazy">
        <span class="badge badge-cate-<?= strtolower(htmlspecialchars($event["category"], ENT_QUOTES, 'UTF-8')) ?> position-absolute top-0 start-0 m-3">
            <?= htmlspecialchars($event["category"], ENT_QUOTES, 'UTF-8') ?>
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
            <?php if ($isCancelled || $isPast): ?>
                <a href="#?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-light btn-sm w-100 border text-center text-muted">
                    Vedi dettagli <span class="visually-hidden"> dell'evento <?= $cleanTitle ?></span>
                </a>

            <?php elseif ($tabContext === 'subscriber-pane'): ?>
                <a href="api/unsubscribe.php?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-danger btn-sm w-100 rounded-3 fw-bold d-flex align-items-center justify-content-center" onclick="return confirm('Vuoi annullare la tua iscrizione?')">
                    <em class="bi bi-person-x me-2" aria-hidden="true"></em> Disiscriviti
                </a>

            <?php elseif ($isOwner || $isAdmin): ?>
                <div class="d-flex flex-wrap gap-2">
                    <?php if ($canPublish): ?>
                        <form action="api/edit_event.php?event_id=<?php echo urlencode($event['id']); ?>" method="POST" class="flex-fill">
                            <input type="hidden" name="publish_from_draft" value="1">
                            <button type="submit" class="btn btn-outline-dark btn-sm w-100 shadow-sm">
                                <span class="bi bi-send me-1"></span> Pubblica
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if ($canEdit): ?>
                        <a href="event.php?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-outline-dark btn-sm flex-fill text-center">
                            <span class="bi bi-pencil" aria-hidden="true"></span> Modifica
                        </a>
                    <?php endif; ?>

                    <div class="d-flex gap-2 w-100 mt-1">
                        <?php if ($canCancel): ?>
                            <a href="api/cancel_event.php?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-warning btn-sm flex-fill fw-bold text-center text-dark" onclick="return confirm('Annullare l\'evento?')">
                                <span class="bi bi-x-circle"></span> Annulla
                            </a>
                        <?php endif; ?>

                        <?php if ($canDelete): ?>
                            <a href="api/delete_event.php?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-danger btn-sm flex-fill text-center" onclick="return confirm('Eliminare l\'evento?')">
                                <span class="bi bi-trash"></span> Elimina
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>