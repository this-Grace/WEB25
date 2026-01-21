<div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Crea Nuovo Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <form id="create-event-form" action="#" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label for="modal-event-title" class="form-label">Titolo Evento</label>
                                <input type="text" class="form-control" id="modal-event-title" name="title" placeholder="es. Workshop di Programmazione Python">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="modal-event-category" class="form-label">Categoria</label>
                                    <select class="form-select" id="modal-event-category" name="category">
                                        <option>Workshop</option>
                                        <option>Conferenza</option>
                                        <option>Seminario</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="modal-event-organizer" class="form-label">Organizzatore</label>
                                    <input type="text" class="form-control" id="modal-event-organizer" name="organizer" placeholder="es. Dipartimento di Informatica">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="modal-event-description" class="form-label">Descrizione</label>
                                <textarea class="form-control" id="modal-event-description" name="description" rows="3" placeholder="Descrivi il tuo evento in dettaglio..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="modal-event-date" class="form-label">Data</label>
                                    <input type="date" class="form-control" id="modal-event-date" name="date">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="modal-event-start-time" class="form-label">Ora Inizio</label>
                                    <input type="time" class="form-control" id="modal-event-start-time" name="start_time">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="modal-event-end-time" class="form-label">Ora Fine</label>
                                    <input type="time" class="form-control" id="modal-event-end-time" name="end_time">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="modal-event-location" class="form-label">Sede</label>
                                    <input type="text" class="form-control" id="modal-event-location" name="location" placeholder="es. Aula Magna">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="modal-event-address" class="form-label">Indirizzo</label>
                                    <input type="text" class="form-control" id="modal-event-address" name="address" placeholder="es. Via Celoria 1, Milano">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="modal-event-max-participants" class="form-label">Numero Massimo Partecipanti</label>
                                    <input type="number" class="form-control" id="modal-event-max-participants" name="max_participants" value="150">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="modal-event-registration-deadline" class="form-label">Scadenza Iscrizioni</label>
                                    <input type="date" class="form-control" id="modal-event-registration-deadline" name="registration_deadline">
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="modal-event-mandatory-registration" name="mandatory_registration" checked>
                                <label class="form-check-label" for="modal-event-mandatory-registration">Registrazione Obbligatoria</label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Immagine Evento</label>
                                <div id="modal-image-dropzone" class="border-dashed p-3 mb-2" role="button" tabindex="0" aria-label="Trascina o seleziona immagine evento">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-3">
                                        <span class="bi bi-upload fs-2 text-muted" aria-hidden="true"></span>
                                        <p class="mb-0 small text-muted">Trascina un'immagine o clicca per selezionarla</p>
                                    </div>
                                    <input class="d-none" type="file" id="modal-event-image" name="image" accept="image/*">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-5">
                            <h6 class="mb-3">Anteprima</h6>
                            <div class="card event-card" id="create-event-preview-card">
                                <img id="create-event-preview-image" src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop" class="card-img-top" alt="Anteprima evento">
                                <div class="card-body d-flex flex-column">
                                    <h3 id="create-event-preview-title" class="card-title h6">Titolo del tuo evento</h3>
                                    <p id="create-event-preview-meta" class="card-text text-muted small flex-grow-1">
                                        <span class="bi bi-calendar" aria-hidden="true"></span> Data e ora<br>
                                        <span class="bi bi-geo-alt" aria-hidden="true"></span> Luogo<br>
                                        <span class="bi bi-people" aria-hidden="true"></span> Partecipanti
                                    </p>
                                    <a href="#" class="btn btn-dark w-100 mt-auto disabled">Iscriviti all'evento</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" name="save_draft" class="btn btn-secondary">Salva come Bozza</button>
                    <button type="submit" name="publish" class="btn btn-primary">Pubblica Evento</button>
                </div>
            </form>
        </div>
    </div>
</div>