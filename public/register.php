<?php

$templateParams['section'] = "Register";

$templateParams["content"] = <<<HTML
    <main id="main-content" class="auth-form-container">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h1 class="h3 fw-bold text-center mb-4">Crea il tuo Account</h1>
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control form-control-lg" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Indirizzo Email</label>
                        <input type="email" class="form-control form-control-lg" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-lg" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Conferma Password</label>
                        <input type="password" class="form-control form-control-lg" id="confirm-password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-light btn-lg">Registrati</button>
                    </div>
                </form>
                <div class="text-center mt-4">
                    <p class="small">Hai già un account? <a href="login.php">Accedi</a></p>
                </div>
            </div>
        </div>
    </main>
HTML;

require 'template/base.php';
