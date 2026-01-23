<?php
/** mockup data */
$user = [
    'first_name' => 'Marco',
    'last_name' => 'Rossi',
    'email' => 'marco.rossi@studenti.unimi.it',
    'avatar' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?q=80&w=2080&auto=format&fit=crop',
];

$eventi_iscritti = [
    ['titolo' => 'Workshop React Advanced per lo sviluppo di Web App moderne', 'data' => '25/01/2026', 'cat' => 'workshop'],
    ['titolo' => 'Conferenza AI & Etica: il futuro della tecnologia', 'data' => '02/02/2026', 'cat' => 'conferenze']
];

$eventi_organizzati = [
    [
        'titolo' => 'Intro a Python per matricole e appassionati',
        'data' => '10/01/2026',
        'iscritti' => 45,
        'capienza_max' => 50,
        'cat' => 'workshop'
    ]
];
?>

<main class="py-5 bg-light">
    <div class="container">

        <section class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden profile-header-card" aria-labelledby="view-fullname">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex flex-column flex-md-row align-items-center gap-4">

                    <div class="avatar-container">
                        <img src="<?= $user['avatar']; ?>" id="display-avatar" class="profile-img shadow" alt="Foto profilo di <?= $user['first_name']; ?>">
                        <label for="avatarUpload" class="avatar-edit-btn shadow-sm" title="Cambia foto profilo">
                            <span class="bi bi-camera" aria-hidden="true"></span>
                            <span class="visually-hidden">Carica nuova foto profilo</span>
                            <input type="file" id="avatarUpload" class="d-none" onchange="previewImage(this)">
                        </label>
                    </div>

                    <div class="flex-grow-1 text-center text-md-start" id="profile-container">

                        <div class="name-group mb-1">
                            <div class="view-mode">
                                <h2 class="fw-bold mb-0" id="view-fullname"><?= $user['first_name'] . ' ' . $user['last_name']; ?></h2>
                            </div>
                            <div class="edit-mode d-none" id="wrapper-name-edit">
                                <div class="edit-input-flex">
                                    <input type="text" id="input-first-name" name="first_name"
                                        class="form-control-inline profile-title-edit fw-bold"
                                        value="<?= $user['first_name']; ?>"
                                        aria-label="Modifica Nome" title="Nome">

                                    <input type="text" id="input-last-name" name="last_name"
                                        class="form-control-inline profile-title-edit fw-bold"
                                        value="<?= $user['last_name']; ?>"
                                        aria-label="Modifica Cognome" title="Cognome">
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
                                    <span class="bi bi-envelope me-2" aria-hidden="true"></span>
                                    <input type="email" id="input-email" name="email"
                                        class="form-control-inline profile-sub-edit"
                                        value="<?= $user['email']; ?>"
                                        aria-label="Modifica Email" title="Indirizzo Email">
                                </div>
                            </div>
                        </div>

                        <div class="view-mode">
                            <button onclick="toggleEdit(true)" class="btn btn-outline-secondary btn-tiny rounded-pill">
                                <span class="bi bi-pencil me-1" aria-hidden="true"></span>Modifica
                            </button>
                        </div>
                        <div class="edit-mode d-none">
                            <button onclick="saveProfile()" class="btn btn-primary btn-sm rounded-3 px-3 py-1 shadow-sm fw-bold" id="btn-save">
                                Salva
                            </button>
                            <button onclick="toggleEdit(false)" class="btn btn-link btn-sm text-muted text-decoration-none ms-2">
                                Annulla
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="row">
            <div class="col-12">
                <nav aria-label="Navigazione eventi">
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

                    <div class="tab-pane fade show active" id="iscritti-pane" role="tabpanel" aria-labelledby="iscritti-tab">
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($eventi_iscritti as $ev): ?>
                                <article class="card border-0 shadow-sm rounded-4 event-wide-card">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="category-icon-box badge-cate-<?= $ev['cat'] ?>">
                                                    <span class="bi bi-calendar-event fs-4" aria-hidden="true"></span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <h3 class="h5 fw-bold mb-1"><?= $ev['titolo'] ?></h3>
                                                <div class="text-muted small">
                                                    <span class="me-3"><span class="bi bi-calendar3 me-1" aria-hidden="true"></span><?= $ev['data'] ?></span>
                                                    <span class="badge-type text-uppercase">#<?= $ev['cat'] ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-auto mt-3 mt-md-0 text-end">
                                                <button class="btn btn-outline-danger btn-sm rounded-pill px-3">Annulla Iscrizione</button>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="organizzati-pane" role="tabpanel" aria-labelledby="organizzati-tab">
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($eventi_organizzati as $ev):
                                $percentuale = ($ev['iscritti'] / $ev['capienza_max']) * 100;
                                $bar_color = ($percentuale >= 90) ? 'bg-danger' : (($percentuale >= 70) ? 'bg-warning' : 'bg-primary');
                            ?>
                                <article class="card border-0 shadow-sm rounded-4 event-wide-card">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 mb-3 mb-md-0">
                                                <h3 class="h5 fw-bold mb-1"><?= $ev['titolo'] ?></h3>
                                                <div class="text-muted small">
                                                    <span class="badge-cate-<?= $ev['cat'] ?>-text fw-bold text-uppercase" style="font-size: 0.7rem;">
                                                        <?= $ev['cat'] ?>
                                                    </span>
                                                    <span class="ms-2"><span class="bi bi-calendar3 me-1" aria-hidden="true"></span><?= $ev['data'] ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                <div class="d-flex justify-content-between mb-1 small">
                                                    <span class="text-muted">Iscritti: <?= $ev['iscritti'] ?>/<?= $ev['capienza_max'] ?></span>
                                                    <span class="fw-bold"><?= round($percentuale) ?>%</span>
                                                </div>
                                                <div class="progress custom-progress" role="progressbar" aria-valuenow="<?= round($percentuale) ?>" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar <?= $bar_color ?>" style="width: <?= $percentuale ?>%"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-md-end">
                                                <div class="btn-group manage-btn-group">
                                                    <a href="#" class="btn btn-manage border-end">Modifica</a>
                                                    <a href="#" class="btn btn-manage">Partecipanti</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>