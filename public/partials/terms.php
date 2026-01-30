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
                    <p class="small text-muted">La piattaforma offre strumenti per la gestione degli eventi, la comunicazione tra organizzatori e partecipanti e la promozione di attività compatibili con le politiche dell'Ateneo.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">2. Responsabilità dell'Organizzatore</h2>
                    <p>Ogni studente che crea un evento agisce come unico responsabile dello stesso. <?= htmlspecialchars($templateParams['brand']); ?> non è responsabile per:</p>
                    <ul class="ms-4">
                        <li class="mb-2 italic">Variazioni di orario o luogo.</li>
                        <li class="mb-2 italic">Comportamenti inappropriati dei partecipanti.</li>
                        <li class="mb-2 italic">Eventuali danni materiali durante l'evento.</li>
                    </ul>
                    <p class="small">Gli organizzatori devono fornire informazioni veritiere e aggiornate e rispettare le normative locali e i regolamenti dell'Ateneo.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">3. Regole della Community</h2>
                    <p>È severamente vietato pubblicare eventi che promuovano attività illegali, discriminazioni o che violino i regolamenti dell'Ateneo di riferimento tramite <?= htmlspecialchars($templateParams['brand']); ?>.</p>
                    <ul class="ms-4">
                        <li class="mb-2 italic">Contenuti offensivi o discriminatori non sono ammessi.</li>
                        <li class="mb-2 italic">È vietata la pubblicazione di informazioni false o fuorvianti.</li>
                    </ul>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">4. Approvazione e Moderazione</h2>
                    <p><?= htmlspecialchars($templateParams['brand']); ?> si riserva il diritto insindacabile di non approvare o rimuovere in qualsiasi momento eventi ritenuti non idonei o contrari ai valori della community.</p>
                    <p class="small">Le decisioni di moderazione possono includere avvisi, sospensioni temporanee o chiusura dell'account in caso di violazioni ripetute.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">5. Privacy e Trattamento dei Dati</h2>
                    <p>Raccogliamo e trattiamo dati personali necessari per l'erogazione del servizio in conformità al GDPR e alla normativa vigente. I dati possono includere nome, email, ruolo accademico e informazioni relative agli eventi.</p>
                    <p class="small">Per dettagli su finalità, conservazione e diritti dell'interessato consultare l'informativa sulla privacy disponibile nel sito o contattare il nostro responsabile della protezione dei dati.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">6. Pagamenti e Rimborsi</h2>
                    <p>Se la piattaforma gestisce transazioni, le condizioni di pagamento e rimborso saranno specificate al momento della creazione dell'evento. <?= htmlspecialchars($templateParams['brand']); ?> non è responsabile per transazioni off-platform tra utenti.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">7. Limitazione di Responsabilità</h2>
                    <p, class="small"><?= htmlspecialchars($templateParams['brand']); ?> non può essere ritenuta responsabile per danni indiretti, perdita di dati o perdite finanziarie derivanti dall'uso della piattaforma, salvo i casi previsti dalla legge.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">8. Cancellazione e Recesso</h2>
                    <p>Gli organizzatori possono cancellare o modificare i propri eventi secondo le procedure previste. I partecipanti possono revocare la propria partecipazione entro i termini indicati dall'organizzatore.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">9. Proprietà Intellettuale</h2>
                    <p>Tutti i contenuti originali pubblicati da <?= htmlspecialchars($templateParams['brand']); ?> sono protetti da diritto d'autore. Gli utenti mantengono i diritti sui contenuti che caricano, concedendo alla piattaforma una licenza non esclusiva per l'utilizzo e la pubblicazione.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">10. Modifiche ai Termini</h2>
                    <p><?= htmlspecialchars($templateParams['brand']); ?> si riserva il diritto di aggiornare questi termini. Le modifiche saranno pubblicate sul sito e, ove appropriato, comunicate agli utenti registrati.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">11. Legge Applicabile e Foro Competente</h2>
                    <p>Questi termini sono disciplinati dalla legge italiana. Per qualsiasi controversia relativa all'interpretazione o esecuzione dei presenti termini, sarà competente il foro del luogo di residenza o domicilio dell'utente se ubicati in Italia, salvo diverse disposizioni inderogabili.</p>
                </section>

                <section class="mb-5">
                    <h2 class="h4 fw-bold">12. Accessibilità e Segnalazioni</h2>
                    <p><?= htmlspecialchars($templateParams['brand']); ?> si impegna a migliorare l'accessibilità del sito. Per problemi di accesso, violazioni o richieste legali contattare il nostro supporto.</p>
                </section>

                <div class="alert alert-info py-3 shadow-sm border-0">
                    <p class="mb-0 small text-center">
                        Per supporto legale o segnalazioni su <strong><?= htmlspecialchars($templateParams['brand']); ?></strong>:
                        <a href="mailto:legal@unievents.it" class="fw-bold"> legal@unievents.it </a>
                    </p>
                </div>

                <div class="text-center mt-4 small text-muted">
                    <p class="mb-1">Se non sei sicuro su come procedere, contatta il team di supporto per assistenza.</p>
                </div>
            </div>
        </div>
    </div>
</main>