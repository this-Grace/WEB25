<header class="text-white">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold mb-3">Eventi Universitari 2026</h1>
        <p class="lead mb-5 opacity-75">Scopri, partecipa e connettiti con la community universitaria</p>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <form class="d-flex" role="search" method="get" action="/events.php">
                    <input name="q" type="search" class="form-control form-control-lg rounded-3 me-2" placeholder="Cerca eventi, organizzazioni o luoghi" aria-label="Cerca">
                    <button class="btn btn-primary btn-lg" type="submit">Cerca</button>
                </form>
            </div>
        </div>

        <div class="row g-4 justify-content-center mt-4">
            <div class="col-6 col-md-2">
                <div class="h3 fw-bold mb-0">250+</div>
                <small class="opacity-75">Eventi Totali</small>
            </div>
            <div class="col-6 col-md-2">
                <div class="h3 fw-bold mb-0">5.000+</div>
                <small class="opacity-75">Studenti Attivi</small>
            </div>
            <div class="col-6 col-md-2">
                <div class="h3 fw-bold mb-0">50+</div>
                <small class="opacity-75">Organizzazioni</small>
            </div>
            <div class="col-6 col-md-2">
                <div class="h3 fw-bold mb-0">12</div>
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
                <a href="<?php echo htmlspecialchars($cat['href'], ENT_QUOTES, 'UTF-8'); ?>"
                    class="<?php echo htmlspecialchars($cat['class'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($cat['label'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<main class="py-5">
    <div class="container border-bottom">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4">Eventi in Evidenza</h2>
        </div>
        <p class="text-muted mb-4 d-none d-lg-block">Scopri i prossimi eventi organizzati dalla nostra università
        </p>

        <div class="row">
            <?php foreach ($templateParams['featured_events'] as $ev) : ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card event-card h-100">
                        <div class="position-relative">
                            <img src="<?php echo htmlspecialchars($ev['img'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                class="card-img-top"
                                alt="<?php echo htmlspecialchars($ev['img_alt'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <span class="<?php echo htmlspecialchars($ev['badge_class'] ?? 'badge badge-cate-default position-absolute top-0 start-0 m-3', ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($ev['category_label'] ?? 'Evento', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title"><?php echo htmlspecialchars($ev['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p id="previewDescription" class="small text-muted mb-2">Breve descrizione dell'evento</p>
                            <p class="card-text text-muted small flex-grow-1">
                                <span class="bi bi-calendar text-primary" aria-hidden="true"></span> <?php echo htmlspecialchars($ev['date'] ?? '', ENT_QUOTES, 'UTF-8'); ?><br>
                                <span class="bi bi-geo-alt text-danger" aria-hidden="true"></span> <?php echo htmlspecialchars($ev['location'] ?? '', ENT_QUOTES, 'UTF-8'); ?><br>
                                <span class="bi bi-people text-success" aria-hidden="true"></span> <?php echo htmlspecialchars($ev['attendees'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                            <a href="<?php echo htmlspecialchars($ev['cta_href'] ?? '#', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-dark w-100 mt-auto"
                                aria-label="<?php echo htmlspecialchars($ev['cta_label'] ?? 'Iscriviti', ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($ev['cta_label'] ?? 'Iscriviti', ENT_QUOTES, 'UTF-8'); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="text-center m-4 w-100">
                <a href="#" class="btn btn-light border border-dark">Carica altri eventi</a>
            </div>
        </div>
</main>

<section class="py-5">
    <div class="container border-bottom">
        <h2 class="text-center mb-4">Statistiche della Community</h2>
        <div class="row text-center">
            <?php foreach ($templateParams['stats'] as $s) : ?>
                <div class="col-md-4 col-6 mb-4">
                    <div class="<?php echo htmlspecialchars($s['card_class'] ?? 'stat-card p-4', ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="stat-icon mb-3">
                            <span class="<?php echo htmlspecialchars($s['icon'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></span>
                        </div>
                        <h3 class="fw-bold"><?php echo htmlspecialchars($s['value'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p class="small"><?php echo htmlspecialchars($s['label'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>