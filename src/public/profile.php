<?php
session_start();

// Dati mock utente
$user = [
    'id' => 1,
    'username' => 'alessandrorebosio',
    'name' => 'Alessandro Rebosio',
    'bio' => 'Engineering and Computer Science 🎓
📍 San Marino | 21 yo
💻 Full Stack Developer',
    'avatar' => 'assets/img/avatar.jpg',
    'posts_count' => 12,
    'followers_count' => 302,
    'following_count' => 149
];

// Mock posts
$posts = array_fill(0, 12, ['image' => 'https://picsum.photos/400/400?random=' . rand(1, 100)]);
$liked_posts = array_fill(0, 8, ['image' => 'https://picsum.photos/400/400?random=' . rand(200, 300)]);

// Mock followers/following
$followers = [
    ['username' => 'mario_rossi', 'name' => 'Mario Rossi', 'avatar' => 'https://ui-avatars.com/api/?name=Mario+Rossi'],
    ['username' => 'giulia_bianchi', 'name' => 'Giulia Bianchi', 'avatar' => 'https://ui-avatars.com/api/?name=Giulia+Bianchi'],
    ['username' => 'luca_verdi', 'name' => 'Luca Verdi', 'avatar' => 'https://ui-avatars.com/api/?name=Luca+Verdi']
];
$following = [
    ['username' => 'sara_neri', 'name' => 'Sara Neri', 'avatar' => 'https://ui-avatars.com/api/?name=Sara+Neri'],
    ['username' => 'paolo_gialli', 'name' => 'Paolo Gialli', 'avatar' => 'https://ui-avatars.com/api/?name=Paolo+Gialli']
];

$pageTitle = $user['name'];
$activePage = 'profile';
$menuItems = [
    ['label' => 'Home', 'link' => 'index.php'],
    ['label' => 'Profilo', 'link' => 'profile.php', 'active' => true]
];

ob_start();
?>

<div class="profile-container">
    <!-- Header Profilo -->
    <div class="mb-5">
        <div class="row align-items-start g-4 mb-4">
            <!-- Avatar -->
            <div class="col-auto">
                <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="<?= htmlspecialchars($user['name']) ?>"
                    class="profile-avatar" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&size=150&background=0d6efd&color=fff'">
            </div>

            <!-- Info Profilo -->
            <div class="col">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="h3 mb-0"><?= htmlspecialchars($user['username']) ?></h1>
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-gear me-1" viewBox="0 0 16 16">
                            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                        </svg>
                        Impostazioni
                    </button>
                </div>

                <div class="d-flex gap-4 mb-4">
                    <div>
                        <span class="fw-semibold"><?= $user['posts_count'] ?></span>
                        <span class="text-muted"> post</span>
                    </div>
                    <button class="btn btn-link p-0 text-decoration-none" data-bs-toggle="modal" data-bs-target="#followersModal">
                        <span class="fw-semibold"><?= $user['followers_count'] ?></span>
                        <span class="text-muted"> follower</span>
                    </button>
                    <button class="btn btn-link p-0 text-decoration-none" data-bs-toggle="modal" data-bs-target="#followingModal">
                        <span class="fw-semibold"><?= $user['following_count'] ?></span>
                        <span class="text-muted"> seguiti</span>
                    </button>
                </div>

                <div class="profile-bio">
                    <strong class="d-block mb-1"><?= htmlspecialchars($user['name']) ?></strong>
                    <p class="mb-0 white-space-pre-line text-muted small"><?= nl2br(htmlspecialchars($user['bio'])) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs nav-fill mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts"
                type="button" role="tab" aria-controls="posts" aria-selected="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid-3x3" viewBox="0 0 16 16">
                    <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0h13A1.5 1.5 0 0 1 16 1.5v13a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5zM1.5 1a.5.5 0 0 0-.5.5V5h4V1zM5 6H1v4h4zm1 4h4V6H6zm-1 1H1v3.5a.5.5 0 0 0 .5.5H5zm1 0v4h4v-4zm5 0v4h3.5a.5.5 0 0 0 .5-.5V11zm0-1h4V6h-4zm0-5h4V1.5a.5.5 0 0 0-.5-.5H11zm-1 0V1H6v4z" />
                </svg>
                <span class="d-none d-md-inline ms-2">Post</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="liked-tab" data-bs-toggle="tab" data-bs-target="#liked"
                type="button" role="tab" aria-controls="liked" aria-selected="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                </svg>
                <span class="d-none d-md-inline ms-2">Mi piace</span>
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Posts Tab -->
        <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
            <div class="posts-grid">
                <?php foreach ($posts as $post): ?>
                    <a href="#" class="post-item">
                        <img src="<?= htmlspecialchars($post['image']) ?>" alt="Post" class="img-fluid">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Liked Tab -->
        <div class="tab-pane fade" id="liked" role="tabpanel" aria-labelledby="liked-tab">
            <div class="posts-grid">
                <?php foreach ($liked_posts as $post): ?>
                    <a href="#" class="post-item">
                        <img src="<?= htmlspecialchars($post['image']) ?>" alt="Post piaciuto" class="img-fluid">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modifica Profilo -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title w-100 text-center" id="editProfileModalLabel">Modifica profilo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action py-3" data-bs-toggle="modal" data-bs-target="#editInfoModal" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle me-2" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                        </svg>
                        Modifica informazioni profilo
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3" data-bs-toggle="modal" data-bs-target="#changePasswordModal" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key me-2" viewBox="0 0 16 16">
                            <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8m4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5" />
                            <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                        </svg>
                        Cambia password
                    </a>
                    <a href="logout.php" class="list-group-item list-group-item-action py-3 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                        </svg>
                        Logout
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 text-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash me-2" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                        Cancella account
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cancella Account -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger" id="deleteAccountModalLabel">Conferma cancellazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Sei sicuro di voler cancellare il tuo account? Questa azione è irreversibile.</p>
                <p class="text-muted small">Tutti i tuoi dati, post e connessioni saranno eliminati permanentemente.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-danger">Elimina account</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Followers -->
<div class="modal fade" id="followersModal" tabindex="-1" aria-labelledby="followersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title w-100 text-center" id="followersModalLabel">Follower</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2">
                <?php if (empty($followers)): ?>
                    <p class="text-center text-muted py-4">Nessun follower</p>
                <?php else: ?>
                    <?php foreach ($followers as $follower): ?>
                        <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                            <img src="<?= htmlspecialchars($follower['avatar']) ?>" alt="<?= htmlspecialchars($follower['name']) ?>"
                                class="rounded-circle" width="44" height="44" style="object-fit: cover;">
                            <div class="flex-grow-1">
                                <div class="fw-semibold"><?= htmlspecialchars($follower['username']) ?></div>
                                <div class="text-muted small"><?= htmlspecialchars($follower['name']) ?></div>
                            </div>
                            <button class="btn btn-sm btn-primary">Segui</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Following -->
<div class="modal fade" id="followingModal" tabindex="-1" aria-labelledby="followingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title w-100 text-center" id="followingModalLabel">Seguiti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2">
                <?php if (empty($following)): ?>
                    <p class="text-center text-muted py-4">Non segui nessuno</p>
                <?php else: ?>
                    <?php foreach ($following as $user_followed): ?>
                        <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                            <img src="<?= htmlspecialchars($user_followed['avatar']) ?>" alt="<?= htmlspecialchars($user_followed['name']) ?>"
                                class="rounded-circle" width="44" height="44" style="object-fit: cover;">
                            <div class="flex-grow-1">
                                <div class="fw-semibold"><?= htmlspecialchars($user_followed['username']) ?></div>
                                <div class="text-muted small"><?= htmlspecialchars($user_followed['name']) ?></div>
                            </div>
                            <button class="btn btn-sm btn-outline-secondary">Smetti di seguire</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modifica Informazioni -->
<div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title w-100 text-center" id="editInfoModalLabel">Modifica informazioni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="editName" value="<?= htmlspecialchars($user['name']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="editUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editUsername" value="<?= htmlspecialchars($user['username']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="editBio" class="form-label">Bio</label>
                        <textarea class="form-control" id="editBio" rows="4"><?= htmlspecialchars($user['bio']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" placeholder="esempio@email.com">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-primary">Salva modifiche</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cambia Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title w-100 text-center" id="changePasswordModalLabel">Cambia password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Password attuale</label>
                        <input type="password" class="form-control" id="currentPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Nuova password</label>
                        <input type="password" class="form-control" id="newPassword" required>
                        <div class="form-text">Minimo 8 caratteri</div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Conferma nuova password</label>
                        <input type="password" class="form-control" id="confirmPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-primary">Cambia password</button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'template/base.php';
?>