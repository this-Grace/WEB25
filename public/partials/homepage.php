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
            <a href="#filter-tutti" class="btn-cate active">Tutti</a>
            <a href="#filter-conferenze" class="btn-cate btn-cate-conferenze">Conferenze</a>
            <a href="#filter-workshop" class="btn-cate btn-cate-workshop">Workshop</a>
            <a href="#filter-seminari" class="btn-cate btn-cate-seminari">Seminari</a>
            <a href="#filter-networking" class="btn-cate btn-cate-networking">Networking</a>
            <a href="#filter-sport" class="btn-cate btn-cate-sport">Sport</a>
            <a href="#filter-sociali" class="btn-cate btn-cate-social">Social</a>
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
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card event-card h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop"
                            class="card-img-top"
                            alt="Audience listening to a speaker at an artificial intelligence conference presentation">
                        <span class="badge badge-cate-conferenze position-absolute top-0 start-0 m-3">Conferenza</span>
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

            <div class="text-center m-4">
                <a href="#" class="btn btn-dark">Carica altri eventi</a>
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