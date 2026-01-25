<main class="py-4 py-md-5 bg-light flex-grow-1">
    <div class="container">

        <?php if (!empty($templateParams["feedback_msg"])): ?>
            <div class="alert alert-<?= $templateParams["feedback_type"] ?> alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                <span class="bi <?= $templateParams["feedback_type"] === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?> me-2"></span>
                <?= $templateParams["feedback_msg"] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
            </div>
        <?php endif; ?>

        <section class="card border-0 shadow-sm rounded-4 mb-4 mb-md-5 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <form id="profileForm" action="profile.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update_profile">

                    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4">
                        <div class="avatar-container position-relative">
                            <img src="<?= PROFILE_IMG_DIR . $templateParams['user']['avatar']; ?>" id="display-avatar" class="profile-img shadow-sm" alt="Foto profilo">
                            <label for="avatarUpload" class="avatar-edit-btn shadow-sm" title="Modifica foto">
                                <span class="bi bi-camera" aria-hidden="true"></span>
                                <input type="file" id="avatarUpload" name="avatar" class="d-none" onchange="previewImage(this)" accept="image/*">
                            </label>
                        </div>

                        <div class="flex-grow-1 w-100">
                            <div class="profile-info-wrapper">
                                <div class="profile-data-top">
                                    <div class="name-group mb-1">
                                        <div class="view-mode">
                                            <h1 class="fw-bold h3 mb-0"><?= htmlspecialchars($templateParams['user']['name'] . ' ' . $templateParams['user']['surname']); ?></h1>
                                        </div>
                                        <div class="edit-mode d-none">
                                            <input type="text" name="name" class="form-control-inline h3 fw-bold" value="<?= htmlspecialchars($templateParams['user']['name']); ?>" maxlength="50"  placeholder="Nome">
                                            <input type="text" name="surname" class="form-control-inline h3 fw-bold" value="<?= htmlspecialchars($templateParams['user']['surname']); ?>" maxlength="50" placeholder="Cognome">
                                        </div>
                                    </div>
                                    <div class="email-group text-muted">
                                        <div class="view-mode small">
                                            <span class="bi bi-envelope me-1"></span><?= htmlspecialchars($templateParams['user']['email']); ?>
                                        </div>
                                        <div class="edit-mode d-none small">
                                            <input type="email" class="form-control-inline" value="<?= htmlspecialchars($templateParams['user']['email']); ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-actions-wrapper">
                                    <div class="view-mode">
                                        <button type="button" onclick="toggleEdit(true)" class="btn btn-outline-primary fw-bold">Modifica Profilo</button>
                                        <button type="button" class="btn btn-outline-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Elimina Account</button>
                                    </div>
                                    <div class="edit-mode d-none">
                                        <button type="submit" class="btn btn-primary fw-bold shadow-sm">Salva Modifiche</button>
                                        <button type="button" onclick="toggleEdit(false)" class="btn btn-outline-secondary fw-bold">Annulla</button>
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
                <?php foreach ($templateParams['tabs'] as $tab): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $tab['active'] ? 'active' : '' ?> border-0 bg-transparent p-0 pb-2 fw-bold"
                            id="<?= $tab['id'] ?>-tab" data-bs-toggle="tab" data-bs-target="#<?= $tab['id'] ?>"
                            type="button" role="tab" aria-selected="<?= $tab['active'] ? 'true' : 'false' ?>">
                            <?= $tab['label'] ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="tab-content" id="profileTabsContent">
            <?php foreach ($templateParams['tabs'] as $tab): ?>
                <div class="tab-pane fade <?= $tab['active'] ? 'show active' : '' ?>" id="<?= $tab['id'] ?>" role="tabpanel">
                    <?php if (empty($tab['data'])): ?>
                        <div class="text-center py-5 text-muted bg-white rounded-4 shadow-sm border">
                            <p class="mb-0">Nessun evento presente.</p>
                        </div>
                    <?php else: ?>
                        <div class="row g-4">
                            <?php foreach ($tab['data'] as $event): ?>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <?php $tabId = $tab['id'];
                                    include 'event-card.php'; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h2 class="modal-title h5 fw-bold">Elimina Account</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-0 text-muted">Azione irreversibile.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-3 px-4 fw-bold" data-bs-dismiss="modal">Annulla</button>
                <form action="profile.php" method="POST">
                    <input type="hidden" name="action" value="delete_account">
                    <button type="submit" class="btn btn-danger rounded-3 px-4 fw-bold">Conferma</button>
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
                <p class="mb-0 text-muted">Vuoi annullare l'iscrizione a:<br><strong id="modal-event-name"></strong>?</p>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
                <form action="profile.php" method="POST" class="w-100 d-flex gap-2">
                    <input type="hidden" name="action" value="unsub_event">
                    <input type="hidden" name="event_id" id="modal-event-id">
                    <button type="button" class="btn btn-light flex-grow-1 rounded-3 fw-bold" data-bs-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-outline-danger flex-grow-1 rounded-3 fw-bold">Conferma</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="deleteEventTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h2 class="modal-title h5 fw-bold" id="deleteEventTitle">Elimina Evento</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi modale"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-0 text-muted">Sei sicuro di voler eliminare questo evento? Questa operazione non può essere annullata.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <form action="profile.php" method="POST" class="w-100 d-flex gap-2">
                    <input type="hidden" name="action" value="delete_event">
                    <input type="hidden" name="event_id" id="delete-event-id">
                    <button type="button" class="btn btn-light flex-grow-1 rounded-3 fw-bold" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-danger flex-grow-1 rounded-3 fw-bold shadow-sm">Elimina</button>
                </form>
            </div>
        </div>
    </div>
</div>