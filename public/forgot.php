<?php

$templateParams['section'] = "Forgot Password";

$templateParams["content"] = <<<HTML
    <main id="main-content" class="auth-form-container" role="main" aria-labelledby="forgot-title">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h1 id="forgot-title" class="h3 fw-bold text-center mb-2">Password Dimenticata?</h1>
                <p class="text-center text-muted mb-4 small">Inserisci la tua email per ricevere le istruzioni e resettare la password.</p>
                <div id="form-error" role="alert" aria-live="polite" class="visually-hidden"></div>
                <form method="post" action="forgot.php" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Indirizzo Email <span aria-hidden="true">*</span></label>
                        <input name="email" type="email" class="form-control form-control-lg" id="email" required aria-required="true" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">Ti invieremo un link per resettare la password.</div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Resetta Password</button>
                    </div>
                </form>
                <div class="text-center mt-4">
                    <p class="small">Tornare alla pagina di <a href="login.php">Accedi</a></p>
                </div>
            </div>
        </div>
    </main>
HTML;

require 'template/base.php';
