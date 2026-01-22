<main class="py-5 bg-light">
    <div class="container">
        <div class="mb-5">
            <h1 class="fw-bold h2">Crea Nuovo Evento</h1>
            <p class="text-muted">Compila il form per creare un nuovo evento universitario</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <form action="process-event.php" method="POST" enctype="multipart/form-data">

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4"><i class="bi bi-file-text me-2"></i>Informazioni Base</h5>
                            <div class="mb-3">
                                <label for="eventTitleInput" class="form-label small fw-bold">Titolo Evento *</label>
                                <input id="eventTitleInput" name="title" type="text" class="form-control" placeholder="es. Workshop di Programmazione Python">
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label small fw-bold">Organizzatore *</label>
                                    <input name="organizer" type="text" class="form-control" placeholder="es. Dipartimento di Informatica">
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold">Descrizione *</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Descrivi il tuo evento in dettaglio..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4"><i class="bi bi-geo-alt me-2"></i>Luogo</h5>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Sede *</label>
                                <input name="location" type="text" class="form-control" placeholder="es. Aula Magna - Edificio A">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Indirizzo</label>
                                    <input name="address" type="text" class="form-control" placeholder="Via Università 1, Milano">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Aula/Sala</label>
                                    <input name="room" type="text" class="form-control" placeholder="es. Aula 201">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4"><i class="bi bi-tag me-2"></i>Tipo di Evento</h5>
                            <div class="mb-0">
                                <label class="form-label small fw-bold">Seleziona Tipologia *</label>
                                <select class="form-select bg-light" id="eventCategorySelector" name="event_type">
                                    <option value="" selected disabled>Scegli una categoria...</option>
                                    <option value="Conferenze">Conferenze</option>
                                    <option value="Workshop">Workshop</option>
                                    <option value="Seminari">Seminari</option>
                                    <option value="Networking">Networking</option>
                                    <option value="Sport">Sport</option>
                                    <option value="Social">Social</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4"><i class="bi bi-people me-2"></i>Partecipanti</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Numero Massimo Partecipanti *</label>
                                    <input type="number" class="form-control bg-light" placeholder="es. 100">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Scadenza Iscrizioni</label>
                                    <input type="date" class="form-control bg-light">
                                </div>
                            </div>
                            <div class="mt-2">
                                <label class="form-label small fw-bold d-block">Requisiti di Partecipazione</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="only_students" value="1" type="checkbox" id="req1">
                                    <label class="form-check-label small" for="req1">Solo studenti universitari</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="registration_required" value="1" type="checkbox" id="req2">
                                    <label class="form-check-label small" for="req2">Registrazione obbligatoria</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4"><i class="bi bi-upload me-2"></i>Immagine Evento</h5>
                            <div id="drop-area" class="upload-area p-5 border border-2 border-dashed rounded-4 text-center">
                                <i class="bi bi-cloud-arrow-up display-4 text-primary"></i>
                                <h6 class="mt-3 fw-bold">Trascina qui l'immagine o clicca</h6>
                                <p class="small text-muted">PNG, JPG fino a 10MB</p>
                                <input type="file" id="fileElem" name="event_image" accept="image/*" class="d-none">
                                <button type="button" class="btn btn-primary btn-sm px-4" onclick="document.getElementById('fileElem').click()">Seleziona File</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <h6 class="text-muted small mb-3 text-uppercase fw-bold tracking-wider">Anteprima</h6>

                    <div class="card event-card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                        <div class="position-relative">
                            <img id="previewImageSidebar"
                                src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop"
                                class="card-img-top"
                                style="height: 200px; object-fit: cover;"
                                alt="Anteprima immagine evento">

                            <span id="previewCategoryBadge"
                                class="badge position-absolute top-0 start-0 m-3 shadow-sm">
                                Categoria
                            </span>
                        </div>

                        <div class="card-body d-flex flex-column p-4">
                            <h3 id="previewTitleDisplay" class="h5 card-title fw-bold">Titolo del tuo evento</h3>

                            <p class="card-text text-muted small flex-grow-1">
                                <span class="bi bi-calendar me-1" aria-hidden="true"></span> <span id="previewDate">Data da definire</span><br>
                                <span class="bi bi-geo-alt me-1" aria-hidden="true"></span> <span id="previewLocation">Luogo da definire</span><br>
                                <span class="bi bi-people me-1" aria-hidden="true"></span> 0 / <span id="previewMaxSeats">∞</span> iscritti
                            </p>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-primary-subtle border-start border-primary border-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-primary"><i class="bi bi-lightbulb me-2"></i>Suggerimenti</h6>
                            <ul class="small mb-0 mt-2 ps-3 text-primary-emphasis">
                                <li>Usa un titolo chiaro e descrittivo</li>
                                <li>Aggiungi un'immagine accattivante</li>
                                <li>Indica chiaramente la data limite</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark py-3 fw-bold rounded-3 shadow">Pubblica Evento</button>
                        <button type="button" class="btn btn-white py-3 fw-bold rounded-3 border shadow-sm">Salva come Bozza</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>