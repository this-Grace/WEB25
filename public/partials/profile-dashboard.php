<?php

/** mockup data */
$user = [
    'first_name' => 'Marco',
    'last_name' => 'Rossi',
    'email' => 'marco.rossi@studenti.unimi.it',
    'avatar' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?q=80&w=2080&auto=format&fit=crop',
];

$status_map = [
    'DRAFT'     => ['class' => 'bg-secondary', 'label' => 'Bozza'],
    'PUBLISHED' => ['class' => 'bg-warning text-dark', 'label' => 'In Revisione'],
    'APPROVED'  => ['class' => 'bg-success', 'label' => 'Pubblicato'],
    'PASSED'    => ['class' => 'bg-dark', 'label' => 'Concluso'],
    'CANCELLED' => ['class' => 'bg-danger', 'label' => 'Annullato']
];

$eventi_iscritti = [
    [
        'id' => 101,
        'titolo' => 'React Advanced',
        'data_evento' => '2026-01-25 14:30',
        'luogo' => 'Aula Comelico',
        'cat' => 'workshop',
        'status' => 'APPROVED',
        'iscritti' => 20,
        'posti_totali' => 30,
        'immagine' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?q=80&w=500'
    ]
];

$eventi_organizzati = [
    ['id' => 201, 'titolo' => 'Intro a Python', 'data_evento' => '2026-01-10 09:00', 'luogo' => 'Lab Sigma', 'cat' => 'workshop', 'status' => 'APPROVED', 'iscritti' => 45, 'posti_totali' => 50, 'immagine' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=500'],
    ['id' => 202, 'titolo' => 'AI Seminar', 'data_evento' => '2026-02-01 11:00', 'luogo' => 'Aula Magna', 'cat' => 'seminari', 'status' => 'PUBLISHED', 'iscritti' => 0, 'posti_totali' => 100, 'immagine' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?q=80&w=500']
];

$eventi_bozze = [
    ['id' => 301, 'titolo' => 'Design System', 'data_evento' => '2026-02-15 10:00', 'luogo' => 'TBD', 'cat' => 'seminari', 'status' => 'DRAFT', 'iscritti' => 0, 'posti_totali' => 30, 'immagine' => 'https://images.unsplash.com/photo-1586717791821-3f44a563dc4c?q=80&w=500']
];

$eventi_archivio = [
    ['id' => 401, 'titolo' => 'Hackathon 2025', 'data_evento' => '2025-12-01 09:00', 'luogo' => 'Palestra', 'cat' => 'social', 'status' => 'PASSED', 'iscritti' => 120, 'posti_totali' => 120, 'immagine' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=500']
];

$tabs = [
    ['id' => 'iscritti-pane', 'label' => 'Iscrizioni', 'data' => $eventi_iscritti, 'active' => true, 'is_organizer' => false],
    ['id' => 'organizzati-pane', 'label' => 'I Miei Eventi', 'data' => $eventi_organizzati, 'active' => false, 'is_organizer' => true],
    ['id' => 'bozze-pane', 'label' => 'Bozze', 'data' => $eventi_bozze, 'active' => false, 'is_organizer' => true, 'is_draft' => true],
    ['id' => 'storico-pane', 'label' => 'Storico', 'data' => $eventi_archivio, 'active' => false, 'is_organizer' => true]
];
?>

<main class="py-4 py-md-5 bg-light flex-grow-1">
    <div class="container">
        <section class="card border-0 shadow-sm rounded-4 mb-4 mb-md-5 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <form id="profileForm" action="update-profile.php" method="POST" enctype="multipart/form-data">
                    <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                        
                        <div class="avatar-container">
                            <img src="<?= $user['avatar']; ?>" id="display-avatar" class="profile-img shadow-sm" alt="Foto profilo">
                            <label for="avatarUpload" class="avatar-edit-btn shadow-sm" title="Modifica foto">
                                <span class="bi bi-camera"></span>
                                <input type="file" id="avatarUpload" name="avatar" class="d-none" onchange="previewImage(this)" accept="image/*">
                            </label>
                        </div>

                        <div class="flex-grow-1 w-100" id="profile-container">
                            <div class="profile-info-wrapper">

                                <div class="name-group mb-1">
                                    <div class="view-mode">
                                        <h1 class="fw-bold h2 mb-0"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h1>
                                    </div>
                                    <div class="edit-mode d-none">
                                        <div class="input-wrapper">
                                            <input type="text" name="first_name" id="input-first-name" class="form-control-inline profile-title-edit" value="<?= htmlspecialchars($user['first_name']); ?>" placeholder="Nome" maxlength="50" required>
                                        </div>
                                        <div class="input-wrapper">
                                            <input type="text" name="last_name" class="form-control-inline profile-title-edit" value="<?= htmlspecialchars($user['last_name']); ?>" placeholder="Cognome" maxlength="50" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="email-group mb-3 text-muted">
                                    <div class="view-mode d-flex align-items-center">
                                        <span class="bi bi-envelope me-2"></span>
                                        <span><?= htmlspecialchars($user['email']); ?></span>
                                    </div>
                                    <div class="edit-mode d-none align-items-center">
                                        <span class="bi bi-envelope me-2"></span>
                                        <div class="input-wrapper">
                                            <input type="email" id="input-email" name="email" class="form-control-inline profile-sub-edit" value="<?= htmlspecialchars($user['email']); ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-actions-wrapper">
                                    <div class="view-mode d-flex gap-2 flex-wrap">
                                        <button type="button" onclick="toggleEdit(true)" class="btn btn-outline-primary rounded-3 px-4 fw-bold">Modifica</button>
                                        <button type="button" class="btn btn-outline-danger rounded-3 px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Elimina Account</button>
                                    </div>
                                    <div class="edit-mode d-none gap-2">
                                        <button type="submit" class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm">Salva</button>
                                        <button type="button" onclick="toggleEdit(false)" class="btn btn-outline-secondary rounded-3 px-4 fw-bold">Annulla</button>
                                    </div>
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
                    <li class="nav-item" role="presentation">
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
                <div class="tab-pane fade <?= $tab['active'] ? 'show active' : '' ?>" id="<?= $tab['id'] ?>" role="tabpanel">
                    <div class="d-flex flex-column gap-3">

                        <?php if (empty($tab['data'])): ?>
                            <div class="text-center py-5 text-muted bg-white rounded-4 shadow-sm">
                                <p class="mb-0">Nessun evento presente.</p>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($tab['data'] as $ev):
                            $iscritti = $ev['iscritti'] ?? 0;
                            $totali = $ev['posti_totali'] ?? 0;
                            $percentuale = ($totali > 0) ? ($iscritti / $totali) * 100 : 0;
                            $s = $status_map[$ev['status']] ?? ['class' => 'bg-secondary', 'label' => 'N/A'];
                        ?>
                            <article class="card border-0 shadow-sm rounded-4 overflow-hidden event-wide-card">
                                <div class="row g-0 h-100">
                                    <div class="col-md-3 position-relative">
                                        <img src="<?= $ev['immagine'] ?>" class="event-card-img" alt="Locandina">
                                        <?php if ($ev['status'] === 'PASSED'): ?>
                                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 text-white fw-bold small">CONCLUSO</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-9 p-4 d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h2 class="h5 fw-bold mb-1"><?= htmlspecialchars($ev['titolo']) ?></h2>
                                                <span class="badge <?= $s['class'] ?>" style="font-size: 0.65rem;"><?= $s['label'] ?></span>
                                            </div>
                                            <span class="badge badge-cate-<?= strtolower($ev['cat']) ?>">#<?= strtoupper($ev['cat']) ?></span>
                                        </div>

                                        <p class="text-muted small mb-3">
                                            <span class="bi bi-calendar-event me-1"></span><?= date('d/m/Y H:i', strtotime($ev['data_evento'])) ?>
                                            <span class="mx-2 opacity-50">•</span>
                                            <span class="bi bi-geo-alt me-1"></span><?= htmlspecialchars($ev['luogo']) ?>
                                        </p>

                                        <div class="mt-auto pt-3 border-top">
                                            <div class="row align-items-center g-3">
                                                <div class="col-12 col-sm-7">
                                                    <?php if ($ev['status'] !== 'PASSED'): ?>
                                                        <div class="d-flex justify-content-between mb-1 text-muted small">
                                                            <span>Capacità: <?= $iscritti ?>/<?= $totali ?></span>
                                                            <span class="fw-bold"><?= round($percentuale) ?>%</span>
                                                        </div>
                                                        <div class="progress custom-progress">
                                                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $percentuale ?>%"></div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-12 col-sm-5 text-sm-end">
                                                    <?php if ($tab['id'] === 'iscritti-pane' && $ev['status'] !== 'PASSED'): ?>
                                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-3 px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#unsubEventModal" data-event-title="<?= htmlspecialchars($ev['titolo']) ?>" data-event-id="<?= $ev['id'] ?>">Disiscriviti</button>
                                                    <?php elseif ($ev['status'] === 'DRAFT'): ?>
                                                        <div class="d-flex gap-2 justify-content-sm-end">
                                                            <button class="btn btn-primary btn-sm rounded-3 px-3 fw-bold">Pubblica</button>
                                                            <button class="btn btn-outline-dark btn-sm rounded-3 px-2"><span class="bi bi-pencil"></span></button>
                                                        </div>
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

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h2 class="modal-title h5 fw-bold">Elimina Account</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-0 text-muted">Questa azione è <strong>irreversibile</strong>. Perderai tutti i tuoi dati e gli eventi organizzati.</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4 fw-bold" data-bs-dismiss="modal">Annulla</button>
                    <form action="process-delete-account.php" method="POST">
                        <button type="submit" class="btn btn-danger rounded-3 px-4 fw-bold shadow-sm">Conferma Eliminazione</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="unsubEventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h2 class="modal-title h5 fw-bold">Annulla Iscrizione</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body py-4 text-center">
                    <p class="mb-0 text-muted">Vuoi annullare l'iscrizione a:<br><strong id="modal-event-name" class="text-dark"></strong>?</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center">
                    <form action="process-unsub.php" method="POST" class="w-100 d-flex gap-2">
                        <input type="hidden" name="event_id" id="modal-event-id">
                        <button type="button" class="btn btn-light flex-grow-1 rounded-3 fw-bold" data-bs-dismiss="modal">Chiudi</button>
                        <button type="submit" class="btn btn-outline-danger flex-grow-1 rounded-3 fw-bold">Conferma</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>