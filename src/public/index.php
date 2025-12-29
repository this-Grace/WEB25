<?php

require_once __DIR__ . '/../app/Users.php';

$usersModel = new User();
$users = $usersModel->all();

$pageTitle = 'UniMatch | Home';
$activePage = 'home';

ob_start();
?>

<div class="row justify-content-center w-100">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
        <article class="card border-0 rounded-5 mb-4 bg-body-tertiary">
            <div class="card-body p-4">
                <h1 class="visually-hidden">UniMatch</h1>
                <h2 class="card-title h5">App per la gestione dello studio</h2>
                <div class="text-primary fw-semibold small">@mrossi</div>
                <p class="mt-2">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, error assumenda quos est
                    maiores dicta impedit tempora omnis dolorem ducimus? Nesciunt laudantium natus hic
                    asperiores magni accusamus. Modi, voluptates sint.
                </p>
                <ul class="list-unstyled mt-3 pt-3 border-top">
                    <li class="py-1">
                        <strong>Corso:</strong> Ingegneria Informatica
                    </li>
                    <li class="py-1">
                        <strong>Team richiesto:</strong> 2 persone
                    </li>
                </ul>
            </div>
        </article>

        <div class="actions d-flex justify-content-center gap-3 my-4">
            <button aria-label="Skip" title="Skip"
                class="btn btn-outline-danger btn-lg rounded-circle border-0 fs-3"><span
                    aria-hidden="true">×</span></button>
            <button aria-label="Like" title="Like"
                class="btn btn-outline-success btn-lg rounded-circle border-0 fs-3"><span
                    aria-hidden="true">♥</span></button>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/template/base.php';
?>