<main class="form-signin d-flex align-items-center justify-content-center py-5 flex-grow-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <form action="../app/controller/login-action.php" method="POST">
                    <div class="text-center mb-4">
                        <i class="bi bi-calendar-check-fill fs-1 text-primary"></i>
                        <h1 class="h3 mb-3 fw-normal">Accedi a UniEvents</h1>
                        <p class="text-muted">Bentornato! Inserisci le tue credenziali.</p>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                        <label for="floatingInput">Indirizzo Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Ricordami
                            </label>
                        </div>
                        <a href="#" class="small text-decoration-none">Password dimenticata?</a>
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
