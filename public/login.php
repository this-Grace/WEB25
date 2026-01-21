<?php

$templateParams['section'] = "Login";

$templateParams["content"] = <<<HTML
    <main id="main-content" class="auth-form-container">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h1 class="h3 fw-bold text-center mb-4">Accedi a UniEvents</h1>
                <form method="post" action="forgot.php" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Indirizzo Email</label>
                        <input type="email" class="form-control form-control-lg" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-lg" id="password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember-me">
                            <label class="form-check-label" for="remember-me">Ricordami</label>
                        </div>
                        <a href="forgot-password.php" class="small">Password dimenticata?</a>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-light btn-lg">Login</button>
                    </div>
                </form>
                <div class="text-center mt-4">
                    <p class="small">Non hai un account? <a href="register.php">Registrati ora</a></p>
                </div>
            </div>
        </div>
    </main>
HTML;

require 'template/base.php';
