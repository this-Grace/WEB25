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
                        <input type="text"
                            class="form-control"
                            id="title"
                            name="title"
                            placeholder="Titolo"
                            required>
                    </div>
                    <!-- Descrizione -->
                    <div class="mb-3">
                        <textarea class="form-control" id="description"
                            name="description" rows="5"
                            placeholder="Descrizione del progetto"
                            required></textarea>
                    </div>
                    <!-- Corso di studi-->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <select class="form-select" id="faculty"
                                name="faculty" required>
                                <option value="">Corso di laurea</option>
                                <option value="engineering">Ingegneria Informatica</option>
                                <option value="cs">Informatica</option>
                                <option value="medicine">Medicina</option>
                                <option value="law">Giurisprudenza</option>
                                <option value="economics">Economia</option>
                            </select>
                        </div>
                        <!-- Numero persone richieste -->
                        <div class="col-md-6">
                            <input type="number"
                                class="form-control"
                                id="num-people"
                                name="num_people"
                                min="1"
                                max="10"
                                placeholder="Persone necessarie"
                                value="2"
                                required>
                        </div>
                    </div>
                    <!-- Skill -->
                    <div class="mb-3">
                        <textarea class="form-control"
                            id="skills"
                            name="skills"
                            rows="3"
                            placeholder="Skill richieste (opzionale)"></textarea>
                    </div>
                    <button type="submit"
                        class="btn btn-primary w-100 mb-3">
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