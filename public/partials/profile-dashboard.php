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

$tabs = [
    ['id' => 'iscritti-pane', 'label' => 'Eventi Iscritti', 'data' => $eventi_iscritti, 'active' => true, 'is_organizer' => false],
    ['id' => 'organizzati-pane', 'label' => 'I tuoi Eventi', 'data' => $eventi_organizzati, 'active' => false, 'is_organizer' => true]
];
?>

<main class="py-4 py-md-5 bg-light flex-grow-1">
    <div class="container">

        <section class="card border-0 shadow-sm rounded-4 mb-4 mb-md-5 overflow-hidden profile-header-card" aria-label="Informazioni Profilo">
            <div class="card-body p-4 p-md-5">
                <form id="profileForm" onsubmit="event.preventDefault();">
                    <div class="d-flex flex-column flex-md-row align-items-center gap-4">

                        <div class="avatar-container">
                            <img src="<?= $user['avatar']; ?>" id="display-avatar" class="profile-img shadow" alt="Foto profilo di <?= $user['first_name']; ?>">

                            <label for="avatarUpload" class="avatar-edit-btn shadow-sm" title="Cambia foto profilo">
                                <span class="bi bi-camera" aria-hidden="true"></span>
                                <span class="visually-hidden">Carica una nuova foto profilo</span>
                                <input type="file" id="avatarUpload" name="avatar" class="d-none" onchange="previewImage(this)">
                            </label>
                        </div>

                        <div class="flex-grow-1 w-100" id="profile-container">
                            <div class="profile-edit-wrapper d-block">

                                <div class="name-group mb-1">
                                    <div class="view-mode">
                                        <h1 class="fw-bold h2 mb-1"><?= $user['first_name'] . ' ' . $user['last_name']; ?></h1>
                                    </div>

                                    <div class="edit-mode d-none w-100" id="wrapper-name-edit">
                                        <div class="d-flex justify-content-center justify-content-md-start gap-1 gap-md-2 flex-nowrap">
                                            <div class="input-group-inline">
                                                <label for="input-first-name" class="visually-hidden">Nome</label>
                                                <input type="text" id="input-first-name" name="first_name" class="form-control-inline profile-title-edit fw-bold" value="<?= $user['first_name']; ?>" title="Modifica il tuo nome">
                                            </div>
                                            <div class="input-group-inline ms-1 ms-md-2">
                                                <label for="input-last-name" class="visually-hidden">Cognome</label>
                                                <input type="text" id="input-last-name" name="last_name" class="form-control-inline profile-title-edit fw-bold" value="<?= $user['last_name']; ?>" title="Modifica il tuo cognome">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="email-group mb-3 text-muted">
                                    <div class="view-mode d-flex align-items-center justify-content-center justify-content-md-start">
                                        <span class="bi bi-envelope me-2" aria-hidden="true"></span>
                                        <span><?= $user['email']; ?></span>
                                    </div>
                                    <div class="edit-mode d-none align-items-center justify-content-center justify-content-md-start">
                                        <span class="bi bi-envelope me-2" aria-hidden="true"></span>
                                        <label for="input-email" class="visually-hidden">Email</label>
                                        <input type="email" id="input-email" name="email"
                                            class="form-control-inline profile-sub-edit"
                                            value="<?= $user['email']; ?>"
                                            title="Modifica la tua email">
                                    </div>
                                </div>
                            </div>

                            <div class="profile-actions-wrapper mt-3">
                                <div class="view-mode d-flex gap-2 justify-content-center justify-content-md-start">
                                    <button type="button" onclick="toggleEdit(true)" class="btn btn-outline-primary btn-sm rounded-3 px-3 fw-bold btn-header-action">
                                        <span class="bi bi-pencil me-1"></span>Modifica
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-3 px-3 fw-bold btn-header-action">
                                        <span class="bi bi-trash me-1"></span>Elimina
                                    </button>
                                </div>
                                <div class="edit-mode d-none gap-2 buttons-edit-wrapper justify-content-center justify-content-md-start">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-3 px-4 fw-bold shadow-sm btn-header-action">Salva</button>
                                    <button type="button" onclick="toggleEdit(false)" class="btn btn-outline-secondary btn-sm rounded-3 px-4 fw-bold btn-header-action">Annulla</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <nav class="nav-tabs-container mb-4">
            <ul class="nav nav-tabs border-0 gap-3 gap-md-4 flex-nowrap" id="profileTabs" role="tablist">
                <?php foreach ($tabs as $tab): ?>
                    <li class="nav-item">
                        <button class="nav-link <?= $tab['active'] ? 'active' : '' ?> border-0 bg-transparent p-0 pb-2 fw-bold"
                            id="<?= $tab['id'] ?>-tab" data-bs-toggle="tab" data-bs-target="#<?= $tab['id'] ?>"
                            type="button" role="tab" aria-controls="<?= $tab['id'] ?>" aria-selected="<?= $tab['active'] ? 'true' : 'false' ?>">
                            <?= $tab['label'] ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="tab-content" id="profileTabsContent">
            <?php foreach ($tabs as $tab): ?>
                <div class="tab-pane fade <?= $tab['active'] ? 'show active' : '' ?>" id="<?= $tab['id'] ?>" role="tabpanel" aria-labelledby="<?= $tab['id'] ?>-tab">
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($tab['data'] as $ev):
                            $percentuale = $tab['is_organizer'] ? ($ev['iscritti'] / $ev['posti_totali']) * 100 : 0;
                            $cat_class = "badge-cate-" . strtolower($ev['cat']);
                        ?>
                            <article class="card border-0 shadow-sm rounded-4 overflow-hidden event-wide-card">
                                <div class="row g-0 h-100">
                                    <div class="col-md-3">
                                        <img src="<?= $ev['immagine'] ?>" class="event-card-img" alt="Immagine dell'evento: <?= $ev['titolo'] ?>">
                                    </div>
                                    <div class="col-md-9 p-3 p-md-4 d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h2 class="h5 fw-bold mb-0"><?= $ev['titolo'] ?></h2>
                                            <span class="badge-cate-tag <?= $cat_class ?>">#<?= strtoupper($ev['cat']) ?></span>
                                        </div>

                                        <div class="row text-muted small g-2 mb-3 mb-md-auto">
                                            <div class="col-12 d-flex align-items-center">
                                                <span class="bi bi-geo-alt me-2 text-primary"></span><?= $ev['luogo'] ?>
                                            </div>
                                            <div class="col-12 d-flex align-items-center">
                                                <span class="bi bi-clock me-2 text-primary"></span>Ore <?= substr($ev['ora_evento'], 0, 5) ?> - <?= date('d/m/Y', strtotime($ev['data_evento'])) ?>
                                            </div>
                                        </div>

                                        <div class="mt-2 mt-md-4 pt-3 border-top">
                                            <div class="row align-items-center g-3">
                                                <div class="col-12 col-sm-7">
                                                    <?php if ($tab['is_organizer']): ?>
                                                        <div class="d-flex justify-content-between mb-1 text-muted small">
                                                            <span>Capienza: <?= $ev['iscritti'] ?>/<?= $ev['posti_totali'] ?></span>
                                                            <span class="fw-bold"><?= round($percentuale) ?>%</span>
                                                        </div>
                                                        <div class="progress custom-progress">
                                                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $percentuale ?>%" aria-valuenow="<?= round($percentuale) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-12 col-sm-5 event-action-wrapper text-end">
                                                    <button class="btn <?= $tab['is_organizer'] ? 'btn-outline-dark' : 'btn-outline-danger' ?> btn-sm rounded-3 fw-bold btn-event">
                                                        <?= $tab['is_organizer'] ? 'Gestisci' : 'Disiscriviti' ?>
                                                    </button>
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