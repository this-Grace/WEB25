<main class="form-signin d-flex align-items-center justify-content-center py-5 flex-grow-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <form action="login.php" method="POST">
                    <div class="text-center mb-4">
                        <i class="bi bi-calendar-check-fill fs-1 text-primary"></i>
                        <h1 class="h3 mb-3 fw-normal">Accedi a UniEvents</h1>
                        <p class="text-muted">Bentornato! Inserisci le tue credenziali.</p>
                    </div>

                    <?php if (isset($_GET['registered'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Registrazione completata! Ora puoi accedere.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php if ($_GET['error'] === 'missing'): ?>
                                Tutti i campi sono obbligatori.
                            <?php elseif ($_GET['error'] === 'invalid'): ?>
                                Credenziali non valide. Riprova.
                            <?php else: ?>
                                Si è verificato un errore.
                            <?php endif; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                        <label for="floatingInput">Indirizzo Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>

                    <button class="w-100 btn btn-lg btn-primary" type="submit">Accedi</button>

                    <p class="mt-4 text-center text-muted">
                        Non hai un account? <a href="register.php">Registrati</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</main>