<?php
$pageTitle = 'Contatti';

$contacts = [
    ['name' => 'Alessandro Rebosio', 'role' => 'Developer', 'email' => 'alessandro.rebosio@studio.unibo.it'],
    ['name' => 'Grazia Bochdanovits de Kavna', 'role' => 'Developer', 'email' => 'grazia.bochdanovits@studio.unibo.it']
];

$iconPerson = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person text-primary" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" /></svg>';
$iconEmail = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope me-2" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" /></svg>';

ob_start();
?>
<div class="text-center mb-5">
    <h1 class="display-5 fw-bold mb-3">Contatti</h1>
    <p class="text-muted">Hai domande? Contattaci!</p>
</div>

<div class="row g-4 justify-content-center">
    <?php foreach ($contacts as $contact): ?>
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <?= $iconPerson ?>
                        </div>
                    </div>
                    <h3 class="h5 mb-2"><?= htmlspecialchars($contact['name']) ?></h3>
                    <p class="text-muted small mb-3"><?= htmlspecialchars($contact['role']) ?></p>
                    <a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="btn btn-sm btn-outline-primary">
                        <?= $iconEmail ?>Email
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php

$content = ob_get_clean();
include 'template/base.php';
