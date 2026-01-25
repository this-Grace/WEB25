<header class="text-white">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold mb-3">Eventi Universitari <?= date('Y') ?></h1>
        <p class="lead mb-5 opacity-75">Scopri, partecipa e connettiti con la community universitaria</p>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <form id="homepage-search-form" class="d-flex" role="search" method="get" action="#">
                    <label for="searchInput" class="visually-hidden">Cerca eventi, organizzazioni o luoghi</label>
                    <input id="searchInput" name="q" type="search" class="form-control" placeholder="Cerca eventi..." aria-label="Cerca">
                    <button class="btn btn-primary btn-lg visually-hidden" type="submit">Cerca</button>
                </form>
            </div>
        </div>

        <div class="row g-4 justify-content-center mt-4">
            <?php
            $stats = [
                ['value' => htmlspecialchars($templateParams["total_events"] ?? '0', ENT_QUOTES, 'UTF-8'), 'label' => 'Eventi Totali'],
                ['value' => htmlspecialchars($templateParams["active_student"] ?? '0', ENT_QUOTES, 'UTF-8'), 'label' => 'Studenti Attivi'],
                ['value' => htmlspecialchars($templateParams["total_hoster"] ?? '0', ENT_QUOTES, 'UTF-8'), 'label' => 'Organizzazioni'],
                ['value' => htmlspecialchars($templateParams["total_categories"] ?? '0', ENT_QUOTES, 'UTF-8'), 'label' => 'Categorie']
            ];

            foreach ($stats as $stat): ?>
                <div class="col-6 col-md-2">
                    <h2 class="fw-bold mb-0"><?= $stat['value'] ?></h2>
                    <small class="opacity-75"><?= $stat['label'] ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</header>

<section class="py-4 border-bottom bg-white">
    <div class="container">
        <h2 class="visually-hidden">Filtra eventi per categoria</h2>
        <div class="d-flex justify-content-center flex-wrap gap-2">
            <?php $userRole = strtolower($_SESSION['user']['role'] ?? '');
            if (in_array($userRole, ['host', 'admin'], true)): ?>
                <a href="#" class="btn-cate btn-cate-miei" data-id="<?= htmlspecialchars($_SESSION['user']['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">Miei</a>
            <?php endif; ?>

            <?php if ($userRole === 'admin'): ?>
                <a href="#" class="btn-cate btn-cate-waiting" data-id="waiting">Waiting</a>
            <?php endif; ?>

            <?php if (!empty($templateParams['categories'] ?? []) && (in_array($userRole, ['host', 'admin'], true) || $userRole === 'admin')): ?>
                <div class="vr mx-2" role="separator" aria-orientation="vertical" aria-hidden="true"></div>
            <?php endif; ?>

            <?php foreach ($templateParams['categories'] ?? [] as $cat): ?>
                <a href="<?= strtolower($cat['name'] ?? '') ?>"
                    class="btn-cate btn-cate-<?= strtolower($cat['name'] ?? '') ?>"
                    data-id="<?= htmlspecialchars($cat['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars(ucfirst(strtolower($cat['name'] ?? '')), ENT_QUOTES, 'UTF-8') ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<main class="py-5">
    <div class="container border-bottom">
        <div id="active-filters-section" class="mb-4" style="display: none;">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                <h2 class="h6 text-muted mb-0 fw-bold">FILTRI ATTIVI</h2>
                <button id="clear-filters-btn" class="btn btn-sm btn-link text-danger text-decoration-none">Rimuovi</button>
            </div>
            <div id="active-filters-list" class="d-flex flex-wrap gap-2">
                <!-- Active filters will be shown here -->
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4">Eventi in Evidenza</h2>
        </div>
        <p class="text-muted mb-4 d-none d-lg-block">Scopri i prossimi eventi organizzati dalla nostra università</p>

        <?php if (empty($templateParams["featured_events"])): ?>
            <div class="text-center py-5">
                <p class="text-muted">Nessun evento disponibile al momento.</p>
            </div>
        <?php else: ?>
            <div id="events-grid" class="row">
                <?php foreach ($templateParams["featured_events"] as $event): ?>
                    <div class="col-lg-4 col-md-6 mb-4"
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
                                    <?= (int)($event['occupied_seats'] ?? 0) ?>/<?= (int)($event['total_seats'] ?? 0) ?> iscritti
                                </p>

                                <a href="?id=<?php echo urlencode($event['id']); ?>" class="btn btn-secondary w-100 mt-auto disabled d-flex align-items-center justify-content-center mb-1">
                                    <i class="bi bi-x-octagon" aria-hidden="true"></i>
                                    <span class="ms-2 d-none d-md-inline">Evento pieno</span>
                                </a>

                                <a href="?id=<?php echo urlencode($event['id']); ?>" class="btn btn-dark w-100 mt-auto d-flex align-items-center justify-content-center mb-1">
                                    <i class="bi bi-person-plus" aria-hidden="true"></i>
                                    <span class="ms-2 d-none d-md-inline">Iscriviti all'evento</span>
                                </a>

                                <a href="?id=<?php echo urlencode($event['id']); ?>" class="btn btn-danger w-100 mt-auto d-flex align-items-center justify-content-center mb-1">
                                    <i class="bi bi-person-x" aria-hidden="true"></i>
                                    <span class="ms-2 d-none d-md-inline">Disiscriviti</span>
                                </a>

                                <div class="d-flex gap-2 w-100 align-items-stretch mb-1">
                                    <a href="?id=<?php echo urlencode($event['id']); ?>" class="btn btn-success d-flex align-items-center justify-content-center flex-fill col-6">
                                        <i class="bi bi-check2-circle" aria-hidden="true"></i>
                                        <span class="ms-2 d-none d-md-inline">Approva</span>
                                    </a>
                                    <a href="?id=<?php echo urlencode($event['id']); ?>" class="btn btn-outline-danger d-flex align-items-center justify-content-center flex-fill col-6">
                                        <i class="bi bi-trash" aria-hidden="true"></i>
                                        <span class="ms-2 d-none d-md-inline">Cancella</span>
                                    </a>
                                </div>

                                <div class="d-flex gap-2 w-100 align-items-stretch mb-1">
                                    <a href="?id=<?php echo urlencode($event['id']); ?>" class="btn btn-outline-primary d-flex align-items-center justify-content-center flex-fill col-6">
                                        <i class="bi bi-pencil" aria-hidden="true"></i>
                                        <span class="ms-2 d-none d-md-inline">Modifica</span>
                                    </a>
                                    <a href="?id=<?php echo urlencode($event['id']); ?>" class="btn btn-warning d-flex align-items-center justify-content-center flex-fill col-6">
                                        <i class="bi bi-x-circle" aria-hidden="true"></i>
                                        <span class="ms-2 d-none d-md-inline">Annulla</span>
                                    </a>
                                </div>

                                <a href="?id=<?php echo urlencode($event['id']); ?>" class="btn btn-secondary w-100 mt-auto disabled d-flex align-items-center justify-content-center mb-1">
                                    <i class="bi bi-slash-circle" aria-hidden="true"></i>
                                    <span class="ms-2 d-none d-md-inline">Annullato</span>
                                </a>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="text-center m-4">
                    <a href="#" class="btn btn-dark">Carica altri eventi</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<section class="py-5">
    <div class="container border-bottom">
        <h2 class="text-center mb-4">Statistiche della Community</h2>
        <div class="row text-center">
            <?php
            $statCards = [
                ['value' => htmlspecialchars($templateParams["event_this_month"] ?? '0', ENT_QUOTES, 'UTF-8'), 'label' => 'Eventi Questo Mese', 'icon' => 'calendar-event', 'class' => 'stat-card-blue'],
                ['value' => htmlspecialchars($templateParams["avg_participation"] ?? '0', ENT_QUOTES, 'UTF-8'), 'label' => 'Partecipazione Media', 'icon' => 'percent', 'class' => 'stat-card-green'],
                ['value' => htmlspecialchars($templateParams["completed_events"] ?? '0', ENT_QUOTES, 'UTF-8'), 'label' => 'Eventi Completati', 'icon' => 'check-circle', 'class' => 'stat-card-orange']
            ];

            foreach ($statCards as $stat): ?>
                <div class="col-12 col-md-4 col-6 mb-4">
                    <div class="stat-card <?= $stat['class'] ?> p-4">
                        <div class="stat-icon mb-3">
                            <span class="bi bi-<?= $stat['icon'] ?>" aria-hidden="true"></span>
                        </div>
                        <h3 class="fw-bold"><?= $stat['value'] ?></h3>
                        <p class="small"><?= $stat['label'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>