<?php
session_start();

$pageTitle = "Home";

// Dati mock utente
$user = [
    'id' => 1,
    'username' => 'mrossi',
    'name' => 'Mario Rossi',
    'avatar' => 'https://ui-avatars.com/api/?name=Mario+Rossi',
];

// Mock post da visualizzare
$posts = [
    [
        'id' => 1,
        'title' => 'App per la gestione dello studio',
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, error assumenda quos est
            maiores dicta impedit tempora omnis dolorem ducimus? Nesciunt laudantium natus hic
            asperiores magni accusamus. Modi, voluptates sint.',
        'degree_course' => 'Ingegneria Informatica',
        'num_collaborators' => 2,
        'author_username' => $user['username']
    ]
];

$menuItems = [
    ['label' => 'Home', 'link' => 'index.php', 'active' => true],
    ['label' => 'Crea', 'link' => 'create-post.php'],
    ['label' => 'Chat', 'link' => 'chat.php'],
    ['label' => 'Profilo', 'link' => 'profile.php']
];

ob_start();
?>

<main class="container flex-grow-1 d-flex align-items-center">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-sm-10 col-md-10 col-lg-8 col-xl-7">
            <?php foreach ($posts as $post): ?>
            <!-- Card del post-->
            <article class="card border-0 rounded-5 mb-4 bg-body-tertiary">
                <div class="card-body p-4 position-relative">
                    <!-- Menu segnalazione post -->
                    <div class="dropdown position-absolute top-0 end-0 m-3">
                        <button class="btn btn-sm btn-link text-body-secondary text-decoration-none"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            aria-label="Azioni post">
                            ⋮
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end rounded-4">
                            <li>
                                <a class="dropdown-item text-danger" href="report-post.php?post=<?= $post['id'] ?>">
                                    Segnala post
                                </a>
                            </li>
                        </ul>
                    </div>

                    <h2 class="card-title h5"><?= htmlspecialchars($post['title']) ?></h2>
                    <div class="text-primary fw-semibold small">@<?= htmlspecialchars($post['author_username']) ?></div>
                    <p class="mt-2"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    <ul class="list-unstyled mt-3 pt-3 border-top">
                        <li class="py-1"><strong>Corso:</strong> <?= htmlspecialchars($post['degree_course']) ?></li>
                        <li class="py-1"><strong>Team richiesto:</strong> <?= intval($post['num_collaborators']) ?> persone</li>
                    </ul>
                </div>
            </article>

            <!-- Azioni utente: like o skip del post -->
            <div class="actions d-flex justify-content-center gap-3 my-4">
                <button aria-label="Skip" title="Skip"
                    class="btn btn-outline-danger rounded-circle d-flex justify-content-center align-items-center"
                    style="width: 60px; height: 60px; font-size: 1.5rem;">
                    ×
                </button>
                <button aria-label="Like" title="Like"
                    class="btn btn-outline-success rounded-circle d-flex justify-content-center align-items-center"
                    style="width: 60px; height: 60px; font-size: 1.5rem;">
                    ♥
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php
$content = ob_get_clean();
require __DIR__ . '/template/base.php';
?>
