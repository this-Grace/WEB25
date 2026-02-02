<?php
$activeTabs = [];

$activeTabs[] = [
    'id' => 'subscriber-pane',
    'label' => 'Iscrizioni',
    'data' => $templateParams["events_subscribed"],
];

if (in_array(strtolower($_SESSION['user']['role'] ?? ''), ['host', 'admin'])) {
    $activeTabs[] = [
        'id' => 'organized-pane',
        'label' => 'Miei Eventi',
        'data' => $templateParams["events_organized"],
    ];
    $activeTabs[] = [
        'id' => 'draft-pane',
        'label' => 'Bozze',
        'data' => $templateParams["events_drafts"],
    ];
    $activeTabs[] = [
        'id' => 'history-pane',
        'label' => 'Storico',
        'data' => $templateParams["events_history"],
    ];
}
?>

<main class="py-4 py-md-5 bg-light flex-grow-1">
    <div class="container">

        <?php if (isset($_GET['msg'])): ?>
            <?php $alertType = isset($_GET['error']) ? 'danger' : 'success'; ?>
            <div class="alert alert-<?= $alertType ?> alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                <span class="bi <?= $alertType === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?> me-2"></span>
                <?php switch ($_GET['msg']):
                    case 'updated': ?>
                        Profilo aggiornato con successo!
                    <?php break;
                    case 'error': ?>
                        Si è verificato un errore durante l'operazione.
                    <?php break;
                    default: ?>
                        Si è verificato un errore.
                <?php endswitch; ?>
                <input type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></input>
            </div>
        <?php endif; ?>

        <section class="card border-0 shadow-sm rounded-4 mb-4 mb-md-5 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <form id="profileForm" action="api/edit_profile.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update_profile">

                    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-center gap-4">
                        <div class="avatar-container">
                            <img src="<?= PROFILE_IMG_DIR . $templateParams['user']['avatar']; ?>" id="display-avatar" class="profile-img" alt="Foto profilo di <?= htmlspecialchars($templateParams['user']['name']); ?>">
                            <label for="avatarUpload" class="avatar-edit-btn edit-mode d-none" title="Cambia foto profilo">
                                <span class="bi bi-camera" aria-hidden="true"></span>
                                <span class="visually-hidden">Carica una nuova foto profilo</span>
                                <input type="file" id="avatarUpload" name="avatar" class="d-none" onchange="previewImage(this)" accept="image/*">
                            </label>
                        </div>

                        <div class="flex-grow-1 w-100 overflow-hidden text-center text-md-start">
                            <div class="name-group mb-1">
                                <div class="view-mode">
                                    <h1 class="fw-bold h3 mb-0 text-truncate"><?= htmlspecialchars($templateParams['user']['name'] . ' ' . $templateParams['user']['surname']); ?></h1>
                                </div>
                                <div class="edit-mode d-none input-scroll-container">
                                    <label for="edit-name" class="visually-hidden">Nome</label>
                                    <input type="text" id="edit-name" name="name" class="form-control-inline h3 fw-bold" value="<?= htmlspecialchars($templateParams['user']['name']); ?>" maxlength="50" placeholder="Nome">

                                    <label for="edit-surname" class="visually-hidden">Cognome</label>
                                    <input type="text" id="edit-surname" name="surname" class="form-control-inline h3 fw-bold" value="<?= htmlspecialchars($templateParams['user']['surname']); ?>" maxlength="50" placeholder="Cognome">
                                </div>
                            </div>
                            <div class="email-group text-muted small">
                                <span class="bi bi-envelope me-1"></span><?= htmlspecialchars($templateParams['user']['email']); ?>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="d-flex justify-content-center justify-content-md-end gap-2 mt-4 border-top pt-3">
                    <div class="view-mode d-flex gap-2">
                        <button type="button" onclick="toggleEdit(true)" class="btn btn-sm btn-outline-primary fw-bold px-3">
                            <span class="bi bi-pencil me-1"></span> Modifica
                        </button>

                        <form action="api/delete_profile.php" method="POST" onsubmit="return confirm('Sei sicuro? L\'azione è irreversibile.')">
                            <button type="submit" class="btn btn-sm btn-outline-danger fw-bold px-3">Elimina</button>
                        </form>
                    </div>

                    <div class="edit-mode d-none gap-2">
                        <button type="submit" form="profileForm" class="btn btn-sm btn-primary fw-bold px-4 shadow-sm">Salva</button>
                        <button type="button" onclick="toggleEdit(false)" class="btn btn-sm btn-outline-secondary fw-bold px-3">Annulla</button>
                    </div>
                </div>
            </div>
        </section>

        <nav class="nav-tabs-container mb-4">
            <ul class="nav nav-tabs border-0 gap-3 gap-md-4 flex-nowrap" id="profileTabs" role="tablist">
                <?php foreach ($activeTabs as $index => $tab): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $index === 0 ? 'active' : '' ?> border-0 bg-transparent p-0 pb-2 fw-bold"
                            id="<?= $tab['id'] ?>-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#<?= $tab['id'] ?>"
                            type="button"
                            role="tab">
                            <?= $tab['label'] ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="tab-content" id="profileTabsContent">
            <?php foreach ($activeTabs as $index => $tab): ?>
                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="<?= $tab['id'] ?>" role="tabpanel">
                    <?php if (empty($tab['data'])): ?>
                        <div class="text-center py-5 text-muted bg-white rounded-4 shadow-sm border border-dashed">
                            <span class="bi bi-calendar-x display-4 mb-3 d-block opacity-25"></span>
                            <p class="mb-0">Nessun evento presente in questa sezione.</p>
                        </div>
                    <?php else: ?>
                        <div class="row g-4">
                            <?php foreach ($tab['data'] as $event): ?>
                                <?php $tabId = $tab['id'];
                                include 'event-card.php'; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>