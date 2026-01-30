<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <h1 class="display-5 fw-bold text-primary mb-4 border-bottom pb-3">
                <?= htmlspecialchars($templateParams['title']); ?>
            </h1>

            <p class="text-muted small">Ultimo aggiornamento: 30 Gennaio 2026</p>

            <div class="mt-5">
                <section class="mb-5">
                    <h2 class="h4 fw-bold">1. Il Servizio <?= htmlspecialchars($templateParams['brand']); ?></h2>
                    <p><?= htmlspecialchars($templateParams['brand']); ?> è una piattaforma dedicata agli studenti universitari per facilitare la creazione, la scoperta e la partecipazione a eventi accademici e sociali.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">2. Responsabilità dell'Organizzatore</h2>
                    <p>Ogni studente che crea un evento agisce come unico responsabile dello stesso. <?= htmlspecialchars($templateParams['brand']); ?> non è responsabile per:</p>
                    <ul class="ms-4">
                        <li class="mb-2 italic">Variazioni di orario o luogo.</li>
                        <li class="mb-2 italic">Comportamenti inappropriati dei partecipanti.</li>
                        <li class="mb-2 italic">Eventuali danni materiali durante l'evento.</li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">3. Regole della Community</h2>
                    <p>È severamente vietato pubblicare eventi che promuovano attività illegali, discriminazioni o che violino i regolamenti dell'Ateneo di riferimento tramite <?= htmlspecialchars($templateParams['brand']); ?>.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">4. Approvazione e Moderazione</h2>
                    <p><?= htmlspecialchars($templateParams['brand']); ?> si riserva il diritto insindacabile di non approvare o rimuovere in qualsiasi momento eventi ritenuti non idonei o contrari ai valori della community.</p>
                </section>

                <div class="alert alert-info py-3 shadow-sm border-0">
                    <p class="mb-0 small text-center">
                        Per supporto legale o segnalazioni su <strong><?= htmlspecialchars($templateParams['brand']); ?></strong>:
                        <a href="#" class="fw-bold"> legal@unievents.it </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>