<main class="py-5 bg-light">
    <div class="container">
        <div class="mb-5">
            <h1 class="fw-bold h2"><?= htmlspecialchars($templateParams["h1"], ENT_QUOTES, 'UTF-8') ?></h1>
            <p class="text-muted">Compila il form per creare un nuovo evento universitario</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <form id="eventForm" action="<?= $templateParams['form_action'] ?>" method="POST" enctype="multipart/form-data">

                    <?php if (!empty($templateParams['event']['id'])): ?>
                        <input type="hidden" name="event_id" value="<?= (int)$templateParams['event']['id'] ?>">
                    <?php endif; ?>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h2 class="card-title mb-4"><span class="bi bi-file-text me-2" aria-hidden="true"></span>Informazioni Base</h2>
                            <div class="mb-3">
                                <label for="eventTitleInput" class="form-label small fw-bold">Titolo Evento <span class="text-danger">*</span></label>
                                <input id="eventTitleInput" name="title" type="text" class="form-control" placeholder="es. Workshop di Programmazione Python" required value="<?= htmlspecialchars($templateParams['event']['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            </div>
                            <div class="mb-0">
                                <label for="eventDescriptionInput" class="form-label small fw-bold">Descrizione <span class="text-danger">*</span></label>
                                <textarea id="eventDescriptionInput" name="description" class="form-control" rows="3" placeholder="Descrivi il tuo evento in dettaglio..." required><?= htmlspecialchars($templateParams['event']['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h2 class="card-title mb-4"><span class="bi bi-calendar-event me-2" aria-hidden="true"></span>Data e Luogo</h2>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="eventDateInput" class="form-label small fw-bold">Data Evento <span class="text-danger">*</span></label>
                                    <input id="eventDateInput" name="event_date" type="date" class="form-control bg-light" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>" value="<?= htmlspecialchars($templateParams['event']['event_date'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="eventTimeHour" class="form-label small fw-bold">Orario <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select id="eventTimeHour" name="event_time_hour" class="form-select bg-light" aria-label="Ora (24H)" required>
                                            <option value="" selected disabled>Ora</option>
                                            <?php for ($h = 0; $h < 24; $h++): $hh = str_pad($h, 2, '0', STR_PAD_LEFT); ?>
                                                <option value="<?= $hh; ?>" <?= explode(':', $templateParams['event']['event_time'])[0] === $hh ? 'selected' : '' ?>><?= $hh; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <select id="eventTimeMinute" name="event_time_minute" class="form-select bg-light" aria-label="Minuti" required>
                                            <option value="" selected disabled>Minuti</option>
                                            <?php for ($m = 0; $m < 60; $m += 15): $mm = str_pad($m, 2, '0', STR_PAD_LEFT); ?>
                                                <option value="<?= $mm; ?>" <?= explode(':', $templateParams['event']['event_time'])[1] === $mm ? 'selected' : '' ?>><?= $mm; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="eventLocationInput" class="form-label small fw-bold">Sede <span class="text-danger">*</span></label>
                                    <input id="eventLocationInput" name="location" type="text" class="form-control" placeholder="es. Aula Magna - Edificio A" required value="<?= htmlspecialchars($templateParams['event']['location'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h2 class="card-title mb-4"><span class="bi bi-sliders me-2" aria-hidden="true"></span>Altro</h2>

                            <div class="mb-4">
                                <label for="eventCategorySelector" class="form-label small fw-bold">Seleziona Tipologia <span class="text-danger">*</span></label>
                                <select class="form-select bg-light" id="eventCategorySelector" name="event_type">
                                    <option value="" selected disabled>Scegli una categoria...</option>
                                    <?php foreach ($templateParams['categories'] ?? [] as $category): $c = htmlspecialchars($category["name"], ENT_QUOTES, 'UTF-8'); ?>
                                        <option value="<?= $c ?>" <?= $category['id'] === $templateParams['event']['category_id'] ? 'selected' : '' ?>><?= $c ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label for="eventMaxSeatsInput" class="form-label small fw-bold">Numero Massimo Partecipanti <span class="text-danger">*</span></label>
                                <input id="eventMaxSeatsInput" name="max_seats" type="number" min="0" class="form-control bg-light mb-2" placeholder="es. 100" required value="<?= htmlspecialchars($templateParams['event']['total_seats'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h2 class="card-title mb-4"><span class="bi bi-upload me-2" aria-hidden="true"></span>Immagine Evento</h2>
                            <div id="drop-area" class="upload-area p-5 border border-2 border-dashed rounded-4 text-center">
                                <span class="bi bi-cloud-arrow-up display-4 text-primary" aria-hidden="true"></span>
                                <h3 class="mt-3 fw-bold">Trascina qui l'immagine o clicca</h3>
                                <p class="small text-muted">PNG, JPG fino a 10MB</p>
                                <label for="fileElem" class="visually-hidden">Seleziona immagine evento (PNG, JPG fino a 10MB)</label>
                                <input type="file" id="fileElem" name="event_image" accept="image/*" class="d-none" title="Seleziona immagine evento (PNG, JPG fino a 10MB)">
                                <input type="button" class="btn btn-primary btn-sm px-4" onclick="document.getElementById('fileElem').click()" value="Seleziona File">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <aside class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <h2 class="text-muted small mb-3 text-uppercase fw-bold tracking-wider">Anteprima</h2>

                    <div class="card event-card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                        <div class="position-relative">
                            <img id="previewImageSidebar"
                                src="<?= htmlspecialchars(!empty($templateParams['event']['image']) ? EVENTS_IMG_DIR . $templateParams['event']['image'] : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop', ENT_QUOTES, 'UTF-8') ?>"
                                class="card-img-top"
                                alt="Anteprima immagine evento">

                            <span id="previewCategoryBadge" class="badge position-absolute top-0 start-0 m-3 shadow-sm">Categoria</span>
                        </div>

                        <div class="card-body d-flex flex-column p-4">
                            <h3 id="previewTitleDisplay" class="h5 card-title fw-bold">Titolo del tuo evento</h3>
                            <p id="previewDescription" class="small text-muted mb-2">Breve descrizione dell'evento</p>

                            <p class="card-text text-muted small flex-grow-1">
                                <span class="bi bi-calendar me-1 text-primary" aria-hidden="true"></span>
                                <span id="previewDate">Data da definire</span>
                                <span id="previewTime" class="ms-2">Ora da definire'</span>
                                <br>
                                <span class="bi bi-geo-alt me-1 text-danger" aria-hidden="true"></span> <span id="previewLocation">Luogo da definire</span><br>
                                <span class="bi bi-people me-1 text-success" aria-hidden="true"></span> 0 / <span id="previewMaxSeats">∞</span> iscritti
                            </p>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-primary-subtle border-start border-primary border-4">
                        <div class="card-body p-4">
                            <h3 class="fw-bold text-primary"><span class="bi bi-lightbulb me-2" aria-hidden="true"></span>Suggerimenti</h3>
                            <ul class="small mb-0 mt-2 ps-3 text-primary-emphasis">
                                <li>Usa un titolo chiaro e descrittivo</li>
                                <li>Aggiungi un'immagine accattivante</li>
                                <li>Indica chiaramente la data limite</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <input type="submit" form="eventForm" name="publish_from_draft" class="btn btn-dark py-3 fw-bold rounded-3 shadow" value="Pubblica Evento">
                        <?php if (empty($templateParams['event']['id'])): ?>
                            <input type="submit" name="save_draft" form="eventForm" class="btn btn-white py-3 fw-bold rounded-3 border shadow-sm" value="Salva come Bozza">
                        <?php endif; ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>