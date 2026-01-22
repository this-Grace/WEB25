<main class="form-signin d-flex align-items-center justify-content-center py-5 flex-grow-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form action="../app/controller/register-action.php" method="POST">
                    <div class="text-center mb-4">
                        <i class="bi bi-calendar-check-fill fs-1 text-primary"></i>
                        <h1 class="h3 mb-3 fw-normal">Crea il tuo Account</h1>
                        <p class="text-muted">Entra a far parte della community di UniEvents.</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Mario" required>
                                <label for="firstName">Nome</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Rossi" required>
                                <label for="lastName">Cognome</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                        <label for="floatingInput">Indirizzo Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Conferma Password" required>
                        <label for="confirmPassword">Conferma Password</label>
                    </div>

                    <div class="form-check text-start my-3">
                        <input class="form-check-input" type="checkbox" value="agree-terms" id="flexCheckDefault" required>
                        <label class="form-check-label" for="flexCheckDefault">
                            Accetto i <a href="#">termini e le condizioni</a>
                        </label>
                    </div>

                    <button class="w-100 btn btn-lg btn-primary" type="submit">Registrati</button>

                    <p class="mt-4 text-center text-muted">
                        Hai già un account? <a href="login.php">Accedi</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</main>
