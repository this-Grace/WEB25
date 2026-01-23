<header class="text-white">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold mb-3">Eventi Universitari 2026</h1>
        <p class="lead mb-5 opacity-75">Scopri, partecipa e connettiti con la community universitaria</p>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <form id="homepage-search-form" class="d-flex" role="search" method="get" action="#">
                    <label for="searchInput" class="visually-hidden">Cerca eventi, organizzazioni o luoghi</label>
                    <input id="searchInput" name="q" type="search" class="form-control form-control-lg rounded-3 me-2" placeholder="Cerca eventi, organizzazioni o luoghi" aria-label="Cerca">
                    <button class="btn btn-primary btn-lg" type="submit">Cerca</button>
                </form>
            </div>
        </div>

        <div class="row g-4 justify-content-center mt-4">
            <div class="col-6 col-md-2">
                <h2 class="fw-bold mb-0">250+</h2>
                <small class="opacity-75">Eventi Totali</small>
            </div>
            <div class="col-6 col-md-2">
                <h2 class="fw-bold mb-0">5.000+</h2>
                <small class="opacity-75">Studenti Attivi</small>
            </div>
            <div class="col-6 col-md-2">
                <h2 class="fw-bold mb-0">50+</h2>
                <small class="opacity-75">Organizzazioni</small>
            </div>
            <div class="col-6 col-md-2">
                <h2 class="fw-bold mb-0"><?php echo count($templateParams['categories'] ?? []); ?></h2>
                <small class="opacity-75">Categorie</small>
            </div>
        </div>
    </div>
</header>

<section class="py-4 border-bottom bg-white">
    <div class="container">
        <h2 class="visually-hidden">Filtra eventi per categoria</h2>
        <div class="d-flex justify-content-center flex-wrap gap-2">
            <?php foreach ($templateParams['categories'] as $cat) : ?>
                <a href="<?php echo htmlspecialchars(strtolower($cat['name']), ENT_QUOTES, 'UTF-8'); ?>"
                    class="btn-cate btn-cate-<?php echo htmlspecialchars(strtolower($cat['name']), ENT_QUOTES, 'UTF-8'); ?>"
                    data-id="<?php echo htmlspecialchars($cat['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars(ucfirst(strtolower($cat['name'])), ENT_QUOTES, 'UTF-8'); ?>
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
        <p class="text-muted mb-4 d-none d-lg-block">Scopri i prossimi eventi organizzati dalla nostra università
        </p>

        <div id="events-grid" class="row">
            <?php foreach ($templateParams['featured_events'] as $ev) : ?>
                <div class="col-lg-4 col-md-6 mb-4" data-category-id="<?php echo htmlspecialchars($ev['category_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="card event-card h-100">
                        <div class="position-relative">
                            <img src="<?php echo EVENTS_IMG_DIR . htmlspecialchars($ev['image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                class="card-img-top"
                                alt="Immagine evento: <?php echo htmlspecialchars($ev['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <span class="badge position-absolute top-0 start-0 m-3 badge-cate-<?php echo htmlspecialchars(strtolower($ev['category_label']), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars(ucfirst(strtolower($ev['category_label'])) ?? 'Evento', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title"><?php echo htmlspecialchars($ev['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p class="preview-description small text-muted mb-2"><?php echo htmlspecialchars($ev['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="card-text text-muted small flex-grow-1">
                                <span class="bi bi-calendar text-primary" aria-hidden="true"></span>
                                <?php
                                $rawDate = $ev['event_date'] ?? '';
                                $displayDate = htmlspecialchars($rawDate, ENT_QUOTES, 'UTF-8');
                                if (!empty($rawDate)) {
                                    $dt = DateTime::createFromFormat('Y-m-d H:i:s', $rawDate);
                                    if ($dt !== false) {
                                        $displayDate = $dt->format('d/m/Y') . ' - ' . $dt->format('H:i');
                                    }
                                }
                                echo $displayDate;
                                ?><br>
                                <span class="bi bi-geo-alt text-danger" aria-hidden="true"></span> <?php echo htmlspecialchars($ev['location'] ?? '', ENT_QUOTES, 'UTF-8'); ?><br>
                                <span class="bi bi-people text-success" aria-hidden="true"></span>
                                <?php
                                $seatsText = '';
                                if (isset($ev['available_seats']) && isset($ev['total_seats'])) {
                                    $seatsText = $ev['available_seats'] . '/' . $ev['total_seats'] . ' iscritti';
                                }
                                echo htmlspecialchars($seatsText, ENT_QUOTES, 'UTF-8');
                                ?>
                            </p>

                            <?php if (isset($_SESSION['user'])) : ?>
                                <a href="<?php echo htmlspecialchars($ev['cta_href'] ?? '#', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-dark w-100 mt-auto"
                                    aria-label="<?php echo htmlspecialchars($ev['cta_label'] ?? 'Iscriviti', ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($ev['cta_label'] ?? 'Iscriviti', ENT_QUOTES, 'UTF-8'); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="text-center m-4 w-100">
                <button id="load-more-btn" data-page="1" data-limit="6" class="btn btn-light border border-dark">Carica altri eventi</button>
            </div>
        </div>
</main>

<section class="py-5">
    <div class="container border-bottom">
        <h2 class="text-center mb-4">Statistiche della Community</h2>
        <div class="row text-center">
            <div class="col-12 col-md-4 mb-4">
                <div class="stat-card stat-card-blue p-4">
                    <div class="stat-icon mb-3">
                        <span class="bi bi-calendar-event" aria-hidden="true"></span>
                    </div>
                    <h3 class="fw-bold">28</h3>
                    <p class="small">Eventi Questo Mese</p>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="stat-card stat-card-green p-4">
                    <div class="stat-icon mb-3">
                        <span class="bi bi-percent" aria-hidden="true"></span>
                    </div>
                    <h3 class="fw-bold">89%</h3>
                    <p class="small">Partecipazione Media</p>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="stat-card stat-card-orange p-4">
                    <div class="stat-icon mb-3">
                        <span class="bi bi-check-circle" aria-hidden="true"></span>
                    </div>
                    <h3 class="fw-bold">188</h3>
                    <p class="small">Eventi Completati</p>
                </div>
            </div>
        </div>
    </div>
</section>