<?php
$totalSeats     = (int)($event['total_seats'] ?? 0);
$occupiedSeats  = (int)($event['occupied_seats'] ?? 0);
$percentage     = ($totalSeats > 0) ? ($occupiedSeats / $totalSeats) * 100 : 0;
$statusInfo     = $templateParams["status_map"][$event['status']] ?? ['class' => 'bg-secondary', 'label' => $event['status']];
$isPast         = strtotime($event['event_date']) < time();
$isCancelled    = ($event['status'] === 'CANCELLED');

$avatar         = EVENTS_IMG_DIR . htmlspecialchars($event["image"], ENT_QUOTES, 'UTF-8');
$cleanTitle     = htmlspecialchars($event["title"] ?? 'Evento senza titolo', ENT_QUOTES, 'UTF-8');
$category       = htmlspecialchars($event["category"] ?? 'Evento', ENT_QUOTES, 'UTF-8');
?>

<article class="card event-card h-100 shadow-sm border-0 rounded-4 overflow-hidden <?php echo ($isPast || $isCancelled) ? 'opacity-75' : ''; ?>">
    <div class="position-relative">
        <img src="<?php echo $avatar; ?>" alt="Locandina dell'evento: <?php echo $cleanTitle; ?>" class="card-img-top" style="height: 160px; object-fit: cover;">

        <span class="badge badge-cate-<?php echo htmlspecialchars(strtolower($event["category"] ?? 'generica')); ?> position-absolute top-0 start-0 m-3">
            <?php echo $category; ?>
        </span>

        <?php if ($tabId !== 'subscriber-pane' && !$isPast && !$isCancelled): ?>
            <span class="badge <?php echo $statusInfo['class']; ?> position-absolute top-0 end-0 m-3">
                <?php echo $statusInfo['label']; ?>
            </span>
        <?php endif; ?>

        <?php if ($isCancelled): ?>
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-danger bg-opacity-25">
                <span class="badge bg-danger shadow">ANNULLATO</span>
            </div>
        <?php elseif ($isPast): ?>
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25">
                <span class="badge bg-dark shadow">CONCLUSO</span>
            </div>
        <?php endif; ?>
    </div>

    <div class="card-body d-flex flex-column p-3">
        <h2 class="h6 card-title fw-bold mb-2"><?php echo $cleanTitle; ?></h2>

        <div class="card-text text-muted small mb-3">
            <div class="mb-1">
                <span class="bi bi-calendar-event text-primary me-2" aria-hidden="true"></span>
                <span class="visually-hidden">Data: </span><?php echo date('d/m/Y', strtotime($event['event_date'])); ?>
            </div>
            <div class="mb-1">
                <span class="bi bi-geo-alt text-success me-2" aria-hidden="true"></span>
                <span class="visually-hidden">Luogo: </span><?php echo htmlspecialchars($event['location'] ?? 'TBD'); ?>
            </div>
        </div>

        <?php if ($tabId === 'organized-pane' && !$isPast && !$isCancelled): ?>
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1 text-muted" style="font-size: 0.7rem;">
                    <span id="prog-label-<?php echo $event['id']; ?>">Capacità: <?php echo $occupiedSeats; ?>/<?php echo $totalSeats; ?></span>
                    <span class="fw-bold"><?php echo round($percentage); ?>%</span>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-primary" role="progressbar"
                        style="width: <?php echo $percentage; ?>%"
                        aria-valuenow="<?php echo round($percentage); ?>"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-labelledby="prog-label-<?php echo $event['id']; ?>"></div>
                </div>
            </div>
        <?php endif; ?>

        <div class="mt-auto pt-2 border-top">
            <?php if ($tabId === 'subscriber-pane' && !$isPast && !$isCancelled): ?>
                <button type="button" class="btn btn-outline-danger btn-sm w-100 rounded-3 fw-bold"
                    data-bs-toggle="modal" data-bs-target="#unsubEventModal"
                    data-event-title="<?php echo $cleanTitle; ?>"
                    data-event-id="<?php echo $event['id']; ?>">
                    <span class="bi bi-x-circle me-1" aria-hidden="true"></span> Disiscriviti
                </button>

            <?php elseif (($tabId === 'organized-pane' || $tabId === 'draft-pane') && !$isPast): ?>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <?php if (($event['status'] ?? '') === 'DRAFT'): ?>
                            <a href="api/approve_event.php?id=<?php echo $event['id']; ?>" class="btn btn-primary btn-sm fw-bold">Pubblica</a>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-outline-dark btn-sm px-2" aria-label="Modifica evento: <?php echo $cleanTitle; ?>">
                            <span class="bi bi-pencil" aria-hidden="true"></span>
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm px-2"
                            data-bs-toggle="modal" data-bs-target="#deleteEventModal"
                            data-event-id="<?php echo $event['id']; ?>"
                            aria-label="Elimina evento: <?php echo $cleanTitle; ?>">
                            <span class="bi bi-trash" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <a href="event_details.php?id=<?php echo $event['id']; ?>" class="btn btn-light btn-sm w-100 rounded-3 text-muted border">
                    Vedi dettagli <span class="visually-hidden">dell'evento <?php echo $cleanTitle; ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</article>