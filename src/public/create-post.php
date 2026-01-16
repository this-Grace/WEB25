<?php
session_start();

$pageTitle  = 'Crea Post';

ob_start();
?>

<div class="row justify-content-center w-100">
    <div class="col-12 col-md-10 col-lg-8 col-xl-7">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4 p-md-5">
                <h1 class="h3 mb-4 text-center">Crea nuovo post</h1>
                <form method="post" novalidate>
                    <!-- Titolo -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Titolo</label>
                        <input type="text"
                            class="form-control rounded-4 border-0 bg-body"
                            id="title"
                            name="title"
                            placeholder="Inserisci il titolo del post"
                            required>
                    </div>
                    <!-- Descrizione -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Descrizione</label>
                        <textarea class="form-control rounded-4 border-0 bg-body" id="description"
                            name="description" rows="5"
                            placeholder="Descrivi il tuo progetto"
                            required></textarea>
                    </div>
                    <!-- Corso di studi-->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="faculty" class="form-label fw-semibold">Corso di laurea</label>
                            <select class="form-select rounded-4 border-0 bg-body" id="faculty"
                                name="faculty" required>
                                <option value="">Seleziona corso</option>
                                <option value="engineering">Ingegneria Informatica</option>
                                <option value="cs">Informatica</option>
                                <option value="medicine">Medicina</option>
                                <option value="law">Giurisprudenza</option>
                                <option value="economics">Economia</option>
                            </select>
                        </div>
                        <!-- Numero persone richieste -->
                        <div class="col-md-6">
                            <label for="num-people" class="form-label fw-semibold">Persone necessarie</label>
                            <input type="number"
                                class="form-control rounded-4 border-0 bg-body"
                                id="num-people"
                                name="num_people"
                                min="1"
                                max="10"
                                value="2"
                                required>
                        </div>
                    </div>
                    <!-- Skill -->
                    <div class="mb-4">
                        <label for="skills" class="form-label fw-semibold">
                            Skill richieste
                            <small class="text-body-secondary">(opzionale)</small>
                        </label>
                        <textarea class="form-control rounded-4 border-0 bg-body"
                            id="skills"
                            name="skills"
                            rows="3"
                            placeholder="Es: HTML, CSS, JavaScript, Python..."></textarea>
                    </div>
                    <button type="submit"
                        class="btn btn-primary w-100 rounded-4 py-2">
                        Pubblica post
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/template/base.php';
?>