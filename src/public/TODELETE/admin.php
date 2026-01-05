<?php
$pageTitle = "Admin Dashboard";

ob_start();
?>
<main class="container flex-grow-1 py-4">
    <div class="mb-4">
        <h1 class="h3">Dashboard Admin</h1>
        <p class="text-body-secondary">Panoramica del sistema UniMatch</p>
    </div>

    <!-- Statistiche -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 rounded-5 bg-body-tertiary">
                <div class="card-body p-4">
                    <h6 class="text-body-secondary small mb-2">Utenti totali</h6>
                    <h3 class="h2 mb-0">1.234</h3>
                    <small class="text-success">+12% questo mese</small>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 rounded-5 bg-body-tertiary">
                <div class="card-body p-4">
                    <h6 class="text-body-secondary small mb-2">Post attivi</h6>
                    <h3 class="h2 mb-0">456</h3>
                    <small class="text-success">+8% questo mese</small>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 rounded-5 bg-body-tertiary">
                <div class="card-body p-4">
                    <h6 class="text-body-secondary small mb-2">Segnalazioni pendenti</h6>
                    <h3 class="h2 mb-0">23</h3>
                    <small class="text-danger">Richiedono attenzione</small>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 rounded-5 bg-body-tertiary">
                <div class="card-body p-4">
                    <h6 class="text-body-secondary small mb-2">Match completati</h6>
                    <h3 class="h2 mb-0">789</h3>
                    <small class="text-success">+5% questo mese</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabella Utenti recenti -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card border-0 rounded-5 bg-body-tertiary">
                <div class="card-header border-0 rounded-top-5 bg-transparent p-4 border-bottom">
                    <h5 class="mb-0">Utenti recenti</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="small text-body-secondary">
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Corso</th>
                                    <th>Data iscrizione</th>
                                    <th class="text-end">Azioni</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td><strong>mrossi</strong></td>
                                    <td>mario.rossi@uni.it</td>
                                    <td>Ing. Informatica</td>
                                    <td>28 dic 2025</td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-primary rounded-3">Visualizza</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>cbianchi</strong></td>
                                    <td>chiara.bianchi@uni.it</td>
                                    <td>Informatica</td>
                                    <td>27 dic 2025</td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-primary rounded-3">Visualizza</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>aconti</strong></td>
                                    <td>andrea.conti@uni.it</td>
                                    <td>Ing. Informatica</td>
                                    <td>26 dic 2025</td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-primary rounded-3">Visualizza</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Segnalazioni recenti -->
    <div class="row g-3">
        <div class="col-12">
            <div class="card border-0 rounded-5 bg-body-tertiary">
                <div class="card-header border-0 rounded-top-5 bg-transparent p-4 border-bottom">
                    <h5 class="mb-0">Segnalazioni recenti</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="small text-body-secondary">
                                <tr>
                                    <th>Motivo</th>
                                    <th>Segnalato da</th>
                                    <th>Data</th>
                                    <th>Stato</th>
                                    <th class="text-end">Azioni</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td>Comportamento inappropriato</td>
                                    <td>mrossi</td>
                                    <td>28 dic 2025</td>
                                    <td><span class="badge bg-warning text-dark rounded-3">In revisione</span></td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-primary rounded-3">Rivedi</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contenuto offensivo</td>
                                    <td>cbianchi</td>
                                    <td>27 dic 2025</td>
                                    <td><span class="badge bg-danger rounded-3">Bloccato</span></td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-primary rounded-3">Rivedi</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Spam</td>
                                    <td>aconti</td>
                                    <td>25 dic 2025</td>
                                    <td><span class="badge bg-success rounded-3">Risolto</span></td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-primary rounded-3">Rivedi</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
$content = ob_get_clean();
require 'template/admin.php';
?>