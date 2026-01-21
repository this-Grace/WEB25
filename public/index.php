<?php

$templateParams['section'] = "Home";

$navPath = 'partials/navbar.php';
$navHtml = '';
if (file_exists($navPath)) {
    ob_start();
    include $navPath;
    $navHtml = ob_get_clean();
}

$content = <<<HTML
<div class="py-3 border-bottom">
    <div class="container">
        <h2 class="visually-hidden">Filtra eventi per categoria</h2>
        <ul class="nav nav-pills justify-content-center flex-wrap gap-2">
            <li class="nav-item"><a href="#filter-tutti" class="nav-link active">Tutti gli eventi</a></li>
            <li class="nav-item"><a href="#filter-conferenze" class="nav-link">Conferenze</a></li>
            <li class="nav-item"><a href="#filter-workshop" class="nav-link">Workshop</a></li>
            <li class="nav-item"><a href="#filter-seminari" class="nav-link">Seminari</a></li>
            <li class="nav-item"><a href="#filter-party" class="nav-link">Party</a></li>
            <li class="nav-item"><a href="#filter-sport" class="nav-link">Sport</a></li>
            <li class="nav-item"><a href="#filter-social" class="nav-link">Social</a></li>
        </ul>
    </div>
</div>

<main class="py-5">
    <div class="container border-bottom">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4">Eventi in Evidenza</h2>
        </div>
        <p class="text-muted mb-4 d-none d-lg-block">Scopri i prossimi eventi organizzati dalla nostra università
        </p>
        <div class="row">
            <!-- Event 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card event-card h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop"
                            class="card-img-top"
                            alt="Audience listening to a speaker at an artificial intelligence conference presentation">
                        <span
                            class="badge bg-white text-primary position-absolute top-0 start-0 m-3">Conferenza</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">Conferenza sull'Intelligenza Artificiale</h3>
                        <p class="card-text text-muted small flex-grow-1">
                            <span class="bi bi-calendar" aria-hidden="true"></span> 25 Gennaio 2026 - 14:30<br>
                            <span class="bi bi-geo-alt" aria-hidden="true"></span> Aula Magna - Edificio A<br>
                            <span class="bi bi-people" aria-hidden="true"></span> 87/150 iscritti
                        </p>
                        <a href="#" class="btn btn-light w-100 mt-auto"
                            aria-label="Iscriviti alla conferenza sull'Intelligenza Artificiale">Iscriviti
                            all'evento</a>
                    </div>
                </div>
            </div>
            <!-- Event 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card event-card h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=2070&auto=format&fit=crop"
                            class="card-img-top"
                            alt="Hands typing on a laptop keyboard during a modern web development workshop">
                        <span
                            class="badge bg-white text-success position-absolute top-0 start-0 m-3">Workshop</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">Workshop Sviluppo Web Moderno</h3>
                        <p class="card-text text-muted small flex-grow-1">
                            <span class="bi bi-calendar" aria-hidden="true"></span> 28 Gennaio 2026 - 10:00<br>
                            <span class="bi bi-geo-alt" aria-hidden="true"></span> Laboratorio Info 3<br>
                            <span class="bi bi-people" aria-hidden="true"></span> 24/30 iscritti
                        </p>
                        <a href="#" class="btn btn-light w-100 mt-auto"
                            aria-label="Iscriviti al workshop Sviluppo Web Moderno">Iscriviti all'evento</a>
                    </div>
                </div>
            </div>
            <!-- Event 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card event-card h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop"
                            class="card-img-top"
                            alt="Robotic arm and advanced robotics equipment used in an advanced robotics seminar">
                        <span class="badge bg-white text-info position-absolute top-0 start-0 m-3">Seminario</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">Seminario di Robotica Avanzata</h3>
                        <p class="card-text text-muted small flex-grow-1">
                            <span class="bi bi-calendar" aria-hidden="true"></span> 1 Febbraio 2026 - 09:30<br>
                            <span class="bi bi-geo-alt" aria-hidden="true"></span> Aula Seminari<br>
                            <span class="bi bi-people" aria-hidden="true"></span> 45/60 iscritti
                        </p>
                        <a href="#" class="btn btn-light w-100 mt-auto"
                            aria-label="Iscriviti al seminario di Robotica Avanzata">Iscriviti all'evento</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center m-4">
            <a href="#" class="btn btn-primary">Carica altri eventi</a>
        </div>
    </div>
</main>

<section class="py-5">
    <div class="container border-bottom">
        <h2 class="text-center mb-4">Statistiche della Community</h2>
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card stat-card-blue p-4">
                    <div class="stat-icon mb-3">
                        <span class="bi bi-calendar-event" aria-hidden="true"></span>
                    </div>
                    <h3 class="fw-bold">28</h3>
                    <p class="small">Eventi Questo Mese</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card stat-card-green p-4">
                    <div class="stat-icon mb-3">
                        <span class="bi bi-percent" aria-hidden="true"></span>
                    </div>
                    <h3 class="fw-bold">89%</h3>
                    <p class="small">Partecipazione Media</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card stat-card-purple p-4">
                    <div class="stat-icon mb-3">
                        <span class="bi bi-check-circle" aria-hidden="true"></span>
                    </div>
                    <h3 class="fw-bold">188</h3>
                    <p class="small">Eventi Completati</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card stat-card-orange p-4">
                    <div class="stat-icon mb-3">
                        <span class="bi bi-star" aria-hidden="true"></span>
                    </div>
                    <h3 class="fw-bold">4.3/5</h3>
                    <p class="small">Valutazione Media</p>
                </div>
            </div>
        </div>
    </div>
</section>
HTML;

$footerHtml = '';
$footerPath = __DIR__ . '/partials/footer.php';
if (file_exists($footerPath)) {
    ob_start();
    include $footerPath;
    $footerHtml = ob_get_clean();
}

$templateParams['content'] = $navHtml . $content . $footerHtml;

require 'template/base.php';
