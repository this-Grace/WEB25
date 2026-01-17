<?php
session_start();

$pageTitle  = 'Segnalazione Post';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO: salvare la segnalazione nel db
    header('Location: index.php?report_sent=1');
    exit;
}

ob_start();
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4 p-md-5">
                <h1 class="h4 mb-3">Segnala contenuto</h1>
                <p class="text-body-secondary small mb-4">
                    La tua segnalazione verrà esaminata dal team UniMatch.
                </p>
                <!-- Form segnalazione -->
                <form method="post" action="">
                    <div class="mb-3">
                        <select class="form-select" name="reason" required>
                            <option value="" selected disabled>Motivo della segnalazione</option>
                            <option value="comportamento">Comportamento inappropriato</option>
                            <option value="contenuto">Contenuto offensivo</option>
                            <option value="spam">Spam</option>
                            <option value="frode">Frode</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <textarea class="form-control" name="description" rows="4" placeholder="Descrizione (opzionale)" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 mb-3">
                        Invia segnalazione
                    </button>

                    <div class="text-center">
                        <a href="index.php" class="auth-link">
                            Annulla
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/template/base.php';
?>