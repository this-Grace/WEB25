<?php

$templateParams['section'] = "Profile";

$navPath = 'partials/navbar-profile.php';
$navHtml = '';
if (file_exists($navPath)) {
    ob_start();
    include $navPath;
    $navHtml = ob_get_clean();
}

$content = <<<HTML
<main id="main-content">
    <div class="container py-5">
        <h1 class="visually-hidden">Profilo utente</h1>
        
        <!-- Profile -->
        <div class="card p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?q=80&w=2080&auto=format&fit=crop"
                        class="img-fluid rounded-circle profile-img" alt="Foto profilo di Marco Rossi">
                </div>
                <div class="col-md-7">
                    <h2 class="h3 fw-bold text-body-emphasis">Marco Rossi</h2>
                    <p class="text-body-secondary mb-1">Studente di Informatica - 3° Anno</p>
                    <p class="text-body-tertiary small">Matricola: 12345678</p>
                    <ul class="list-unstyled d-flex flex-wrap gap-4 text-body-tertiary small mt-3">
                        <li><span class="bi bi-envelope-fill me-2" aria-hidden="true"></span>
                            <a href="mailto:marco.rossi@studenti.unimi.it" class="text-body-tertiary text-decoration-none">
                                marco.rossi@studenti.unimi.it
                            </a>
                        </li>
                        <li><span class="bi bi-telephone-fill me-2" aria-hidden="true"></span>
                            <a href="tel:+393401234567" class="text-body-tertiary text-decoration-none">+39 340 123 4567</a>
                        </li>
                        <li><span class="bi bi-geo-alt-fill me-2" aria-hidden="true"></span>Milano, Italia</li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        Modifica Profilo
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row mb-4 text-center">
            <div class="col-md-4">
                <div class="card p-3 h-100">
                    <span class="bi bi-calendar-check fs-2 text-primary-emphasis" aria-hidden="true"></span>
                    <h3 class="h5 mt-2 mb-0">15 Eventi Frequentati</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 h-100">
                    <span class="bi bi-patch-check-fill fs-2 text-success-emphasis" aria-hidden="true"></span>
                    <h3 class="h5 mt-2 mb-0">Organizzatore Certificato</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 h-100">
                    <span class="bi bi-people-fill fs-2 text-info-emphasis" aria-hidden="true"></span>
                    <h3 class="h5 mt-2 mb-0">Top Networker</h3>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="card mb-4">
            <div class="card-header bg-body-tertiary">
                <ul class="nav nav-tabs profile-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="miei-eventi-tab" data-bs-toggle="tab" 
                                data-bs-target="#miei-eventi" type="button" role="tab" 
                                aria-controls="miei-eventi" aria-selected="true">
                            I Miei Eventi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="organizzati-tab" data-bs-toggle="tab" 
                                data-bs-target="#organizzati" type="button" role="tab" 
                                aria-controls="organizzati" aria-selected="false">
                            Eventi Organizzati
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="attivita-tab" data-bs-toggle="tab" 
                                data-bs-target="#attivita" type="button" role="tab" 
                                aria-controls="attivita" aria-selected="false">
                            Attività
                        </button>
                    </li>
                </ul>
            </div>
            
            <div class="card-body tab-content" id="profileTabsContent">
                
                <!-- Tab 1: My Events -->
                <div class="tab-pane fade show active" id="miei-eventi" role="tabpanel" 
                     aria-labelledby="miei-eventi-tab" tabindex="0">
                    
                    <h2 class="h5 text-body-emphasis mb-4 pb-2 border-bottom">Eventi a cui Partecipi</h2>
                    
                    <!-- Event 1 -->
                    <div class="card event-card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start">
                                        <span class="bi bi-mic me-3 text-info fs-4"></span>
                                        <div>
                                            <h3 class="h5 mb-1 text-body-emphasis">Workshop Data Science</h3>
                                            <div class="event-details">
                                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-calendar-date me-1"></span>
                                                        10 Febbraio 2026
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-clock me-1"></span>
                                                        14:00 - 16:00
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-geo-alt me-1"></span>
                                                        Aula 3, Dipartimento di Informatica
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-column align-items-end gap-2">
                                        <span class="badge text-bg-info">Confermato</span>
                                        <button class="btn btn-outline-secondary btn-sm">
                                            <span class="bi bi-info-circle me-1"></span>
                                            Dettagli
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event 2 -->
                    <div class="card event-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start">
                                        <span class="bi bi-briefcase me-3 text-warning fs-4"></span>
                                        <div>
                                            <h4 class="h5 mb-1 text-body-emphasis">Career Day 2026</h4>
                                            <div class="event-details">
                                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-calendar-date me-1"></span>
                                                        5 Marzo 2026
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-clock me-1"></span>
                                                        9:00 - 18:00
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-geo-alt me-1"></span>
                                                        Centro Congressi Universitario
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-column align-items-end gap-2">
                                        <span class="badge text-bg-warning">In attesa</span>
                                        <button class="btn btn-outline-secondary btn-sm">
                                            <span class="bi bi-info-circle me-1"></span>
                                            Dettagli
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab 2: Events -->
                <div class="tab-pane fade" id="organizzati" role="tabpanel" 
                     aria-labelledby="organizzati-tab" tabindex="0">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                        <h2 class="h5 text-body-emphasis mb-0">Eventi Organizzati</h2>
                        <a href="partials/modal-crea-evento.php" class="btn btn-primary">
                            <span class="bi bi-plus-circle me-2"></span>
                            Crea Nuovo Evento
                        </a>
                    </div>
                    
                    <!-- Event 1 -->
                    <div class="card event-card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start">
                                        <span class="bi bi-calendar-event me-3 text-primary fs-4"></span>
                                        <div>
                                            <h3 class="h5 mb-1 text-body-emphasis">Hackathon Universitario 2026</h3>
                                            <div class="event-details">
                                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-calendar-date me-1"></span>
                                                        15 Marzo 2026
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-clock me-1"></span>
                                                        9:00 - 18:00
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-geo-alt me-1"></span>
                                                        Aula Magna, Campus Leonardo
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-column align-items-end gap-2">
                                        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#manageEventModal">
                                            Gestisci
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-body-secondary">Progresso iscrizioni</small>
                                    <small class="text-body-secondary">45/60 posti</small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" 
                                         aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event 2 -->
                    <div class="card event-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start">
                                        <span class="bi bi-code-slash me-3 text-success fs-4"></span>
                                        <div>
                                            <h4 class="h5 mb-1 text-body-emphasis">Conferenza Python Milano</h4>
                                            <div class="event-details">
                                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-calendar-date me-1"></span>
                                                        22 Aprile 2026
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-clock me-1"></span>
                                                        10:00 - 17:00
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-geo-alt me-1"></span>
                                                        Centro Congressi Milano
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-column align-items-end gap-2">
                                        <a href="#" class="btn btn-primary btn-sm">
                                            <span class="bi bi-gear me-1"></span>
                                            Gestisci
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-body-secondary">Progresso iscrizioni</small>
                                    <small class="text-body-secondary">120/150 posti</small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 80%" 
                                         aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab 3: Activity -->
                <div class="tab-pane fade" id="attivita" role="tabpanel" 
                    aria-labelledby="attivita-tab" tabindex="0">
                    
                    <h2 class="h5 text-body-emphasis mb-4 pb-2 border-bottom">Attività Recente</h2>
                    
                    <!-- Activity 1 -->
                    <div class="card event-card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start">
                                        <span class="bi bi-calendar-check-fill me-3 text-primary fs-4"></span>
                                        <div>
                                            <h3 class="h5 mb-1 text-body-emphasis">Ti sei iscritto a "Workshop: Sviluppo Web Moderno"</h3>
                                            <div class="event-details">
                                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-clock me-1"></span>
                                                        2 giorni fa
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-calendar-date me-1"></span>
                                                        28 Gennaio 2026
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-geo-alt me-1"></span>
                                                        Laboratorio 5, Dipartimento di Informatica
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Activity 2 -->
                    <div class="card event-card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start">
                                        <span class="bi bi-plus-circle-fill me-3 text-success fs-4"></span>
                                        <div>
                                            <h4 class="h5 mb-1 text-body-emphasis">Hai creato l'evento "Hackathon Universitario 2026"</h4>
                                            <div class="event-details">
                                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-clock me-1"></span>
                                                        5 giorni fa
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-people-fill me-1"></span>
                                                        45 partecipanti iscritti
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Activity 3 -->
                    <div class="card event-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start">
                                        <span class="bi bi-patch-check-fill me-3 text-warning fs-4"></span>
                                        <div>
                                            <h4 class="h5 mb-1 text-body-emphasis">Hai ottenuto il badge "Organizzatore Certificato"</h4>
                                            <div class="event-details">
                                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-clock me-1"></span>
                                                        1 settimana fa
                                                    </span>
                                                    <span class="text-body-secondary">
                                                        <span class="bi bi-award me-1"></span>
                                                        Badge di livello avanzato
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </div>

    <!-- Profile Edit Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editProfileModalLabel">Modifica Profilo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="editProfileForm">
            <div class="mb-3">
                <label for="profileName" class="form-label">Nome</label>
                <input type="text" class="form-control" id="profileName" value="Marco Rossi">
            </div>
            <div class="mb-3">
                <label for="profileEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="profileEmail" value="marco.rossi@studenti.unimi.it">
            </div>
            <div class="mb-3">
                <label for="profilePhone" class="form-label">Telefono</label>
                <input type="tel" class="form-control" id="profilePhone" value="+39 340 123 4567">
            </div>
            <div class="mb-3">
                <label for="profileLocation" class="form-label">Posizione</label>
                <input type="text" class="form-control" id="profileLocation" value="Milano, Italia">
            </div>
            <div class="mb-3">
                <label for="profileImage" class="form-label">Foto Profilo</label>
                <input type="file" class="form-control" id="profileImage">
            </div>
            <div class="mb-3">
                <label for="profileStudentId" class="form-label">Matricola</label>
                <input type="text" class="form-control" id="profileStudentId" value="12345678">
            </div>
            <div class="mb-3">
                <label for="profileCourse" class="form-label">Corso di Studi</label>
                <input type="text" class="form-control" id="profileCourse" value="Informatica">
            </div>
            <div class="mb-3">
                <label for="profileYear" class="form-label">Anno di Corso</label>
                <select class="form-select" id="profileYear">
                <option value="1">Primo Anno</option>
                <option value="2">Secondo Anno</option>
                <option value="3" selected>Terzo Anno</option>
                <option value="4">Quarto Anno</option>
                <option value="5">Quinto Anno</option>
                </select>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
            <button type="button" class="btn btn-primary" id="saveProfileBtn">Salva Modifiche</button>
        </div>
        </div>
    </div>
    </div>

    <!-- Manage Event Modal -->
    <div class="modal fade" id="manageEventModal" tabindex="-1" aria-labelledby="manageEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageEventModalLabel">Gestisci Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="manageEventForm">
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Titolo Evento</label>
                            <input type="text" class="form-control" id="eventTitle" value="">
                        </div>
                        <div class="mb-3">
                            <label for="eventDate" class="form-label">Data</label>
                            <input type="date" class="form-control" id="eventDate" value="">
                        </div>
                        <div class="mb-3">
                            <label for="eventTime" class="form-label">Orario</label>
                            <input type="text" class="form-control" id="eventTime" placeholder="Es: 9:00 - 18:00" value="">
                        </div>
                        <div class="mb-3">
                            <label for="eventLocation" class="form-label">Luogo</label>
                            <input type="text" class="form-control" id="eventLocation" value="">
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Descrizione</label>
                            <textarea class="form-control" id="eventDescription" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="eventAvailableSeats" class="form-label">Posti Disponibili</label>
                                <input type="number" class="form-control" id="eventAvailableSeats" value="">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="deleteEventBtn">Elimina Evento</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-primary" id="saveEventBtn">Salva Modifiche</button>
                </div>
            </div>
        </div>
    </div>

</main>
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