<?php
/** mockup data */
$user = [
    'first_name' => 'Marco',
    'last_name' => 'Rossi',
    'email' => 'marco.rossi@studenti.unimi.it',
    'avatar' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?q=80&w=2080&auto=format&fit=crop',
];

$eventi_iscritti = [
    [
        'titolo' => 'React Advanced per lo sviluppo di Web App',
        'data_evento' => '2026-01-25',
        'ora_evento' => '14:30:00',
        'luogo' => 'Aula Magna, Via Comelico',
        'cat' => 'workshop',
        'immagine' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?q=80&w=2070&auto=format&fit=crop'
    ]
];

$eventi_organizzati = [
    [
        'titolo' => 'Intro a Python per matricole',
        'data_evento' => '2026-01-10',
        'ora_evento' => '09:00:00',
        'luogo' => 'Laboratorio Sigma',
        'iscritti' => 45,
        'posti_totali' => 50,
        'cat' => 'workshop',
        'stato' => 'PUBBLICATO',
        'immagine' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=2070&auto=format&fit=crop'
    ]
];
?>

<main class="py-5 bg-light flex-grow-1">
    <div class="container">

        <section class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden profile-header-card" aria-label="Informazioni Profilo">
            <div class="card-body p-4 p-md-5">
                <form id="profileForm" onsubmit="event.preventDefault(); saveProfile();">
                    <div class="d-flex flex-column flex-md-row align-items-center gap-4">

                        <div class="avatar-container">
                            <img src="<?= $user['avatar']; ?>" id="display-avatar" class="profile-img shadow" alt="Foto profilo attuale">
                            <label for="avatarUpload" class="avatar-edit-btn shadow-sm" title="Cambia foto profilo">
                                <span class="bi bi-camera" aria-hidden="true"></span>
                                <span class="visually-hidden">Carica una nuova foto profilo</span>
                                <input type="file" id="avatarUpload" name="avatar" class="d-none" onchange="previewImage(this)">
                            </label>
                        </div>

                        <div class="flex-grow-1 text-center text-md-start" id="profile-container">
                            <div class="profile-edit-wrapper d-inline-block">

                                <div class="name-group mb-1">
                                    <div class="view-mode">
                                        <h1 class="fw-bold h2 mb-0" id="view-fullname"><?= $user['first_name'] . ' ' . $user['last_name']; ?></h1>
                                    </div>
                                    <div class="edit-mode d-none" id="wrapper-name-edit">
                                        <div class="edit-input-flex">
                                            <label for="input-first-name" class="visually-hidden">Nome</label>
                                            <input type="text" id="input-first-name" name="first_name"
                                                class="form-control-inline profile-title-edit fw-bold"
                                                value="<?= $user['first_name']; ?>">

                                            <label for="input-last-name" class="visually-hidden">Cognome</label>
                                            <input type="text" id="input-last-name" name="last_name"
                                                class="form-control-inline profile-title-edit fw-bold"
                                                value="<?= $user['last_name']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="email-group mb-3">
                                    <div class="view-mode text-muted">
                                        <span class="bi bi-envelope me-2" aria-hidden="true"></span>
                                        <span id="view-email"><?= $user['email']; ?></span>
                                    </div>
                                    <div class="edit-mode d-none">
                                        <div class="edit-input-flex text-muted">
                                            <span class="bi bi-envelope me-2 icon-envelope" aria-hidden="true"></span>
                                            <label for="input-email" class="visually-hidden">Indirizzo Email</label>
                                            <input type="email" id="input-email" name="email"
                                                class="form-control-inline profile-sub-edit"
                                                value="<?= $user['email']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2 mt-3">
                                <div class="view-mode">
                                    <button type="button" onclick="toggleEdit(true)" class="btn btn-outline-secondary btn-tiny rounded-pill">
                                        <span class="bi bi-pencil me-1" aria-hidden="true"></span>Modifica
                                    </button>
                                    <button type="button" onclick="confirmDeleteAccount()" class="btn btn-outline-danger btn-tiny rounded-pill ms-md-2">
                                        <span class="bi bi-trash me-1" aria-hidden="true"></span>Elimina Account
                                    </button>
                                </div>

                                <div class="edit-mode d-none">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-3 px-3 py-1 shadow-sm fw-bold">Salva</button>
                                    <button type="button" onclick="toggleEdit(false)" class="btn btn-link btn-sm text-muted text-decoration-none ms-2">Annulla</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <nav aria-label="Navigazione Eventi">
            <ul class="nav nav-tabs border-0 mb-4 gap-4" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active border-0 bg-transparent p-0 pb-2 fw-bold" id="iscritti-tab" data-bs-toggle="tab" data-bs-target="#iscritti-pane" type="button" role="tab" aria-controls="iscritti-pane" aria-selected="true">
                        Eventi Iscritti
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link border-0 bg-transparent p-0 pb-2 fw-bold text-muted" id="organizzati-tab" data-bs-toggle="tab" data-bs-target="#organizzati-pane" type="button" role="tab" aria-controls="organizzati-pane" aria-selected="false">
                        I tuoi Eventi
                    </button>
                </li>
            </ul>
        </nav>

        <div class="tab-content" id="profileTabsContent">
            <?php
            $tabs = [
                ['id' => 'iscritti-pane', 'data' => $eventi_iscritti, 'active' => true, 'is_organizer' => false],
                ['id' => 'organizzati-pane', 'data' => $eventi_organizzati, 'active' => false, 'is_organizer' => true]
            ];
            foreach ($tabs as $tab): ?>
                <div class="tab-pane fade <?= $tab['active'] ? 'show active' : '' ?>" id="<?= $tab['id'] ?>" role="tabpanel" aria-labelledby="<?= $tab['id'] ?>-tab">
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($tab['data'] as $ev):
                            $percentuale = $tab['is_organizer'] ? ($ev['iscritti'] / $ev['posti_totali']) * 100 : 0;
                        ?>
                            <article class="card border-0 shadow-sm rounded-4 overflow-hidden event-wide-card">
                                <div class="row g-0">
                                    <div class="col-md-3 position-relative">
                                        <img src="<?= $ev['immagine'] ?>" class="img-fluid event-card-img h-100" alt="Immagine di: <?= $ev['titolo'] ?>">
                                        <?php if ($tab['is_organizer']): ?>
                                            <span class="badge bg-success position-absolute top-0 start-0 m-3 shadow-sm"><?= $ev['stato'] ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-9 p-4 d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h2 class="h5 fw-bold mb-0"><?= $ev['titolo'] ?></h2>
                                            <span class="badge-cate-tag btn-cate-<?= $ev['cat'] ?>">#<?= strtoupper($ev['cat']) ?></span>
                                        </div>

                                        <div class="row text-muted small g-2 mb-auto">
                                            <div class="col-12"><span class="bi bi-geo-alt me-2 text-primary" aria-hidden="true"></span><?= $ev['luogo'] ?></div>
                                            <div class="col-12"><span class="bi bi-calendar3 me-2 text-primary" aria-hidden="true"></span><?= date('d/m/Y', strtotime($ev['data_evento'])) ?></div>
                                            <div class="col-12"><span class="bi bi-clock me-2 text-primary" aria-hidden="true"></span>Inizio ore <?= substr($ev['ora_evento'], 0, 5) ?></div>
                                        </div>

                                        <div class="event-footer-section mt-4">
                                            <div class="row align-items-end">
                                                <div class="col-sm-8">
                                                    <?php if ($tab['is_organizer']): ?>
                                                        <div class="capacity-info d-flex justify-content-between mb-1 text-muted">
                                                            <span>Capienza: <?= $ev['iscritti'] ?>/<?= $ev['posti_totali'] ?></span>
                                                            <span class="fw-bold"><?= round($percentuale) ?>%</span>
                                                        </div>
                                                        <div class="progress custom-progress">
                                                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $percentuale ?>%" aria-valuenow="<?= round($percentuale) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-sm-4 text-end mt-3 mt-sm-0">
                                                    <?php if ($tab['is_organizer']): ?>
                                                        <a href="edit-event.php?id=..." class="btn btn-manage btn-sm px-4 border rounded-3">Modifica</a>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3">Annulla Iscrizione</button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>