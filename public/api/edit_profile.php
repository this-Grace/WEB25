<?php
require_once __DIR__ . '/../../app/bootstrap.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])) {
    header('Location: ../profile.php');
    exit;
}

$userEmail = $_SESSION['user']['email'];
$name = trim($_POST['name'] ?? $_SESSION['user']['name']);
$surname = trim($_POST['surname'] ?? $_SESSION['user']['surname']);

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../' . PROFILE_IMG_DIR;

    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $fileName = bin2hex(random_bytes(10)) . '.' . $ext;
    $uploadPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath)) {
        $oldAvatar = $_SESSION['user']['avatar'] ?? '';

        if ($userMapper->updateAvatar($userEmail, $fileName)) {
            if (!empty($oldAvatar) && $oldAvatar !== 'default.jpg' && is_file($uploadDir . $oldAvatar)) {
                @unlink($uploadDir . $oldAvatar);
            }
            $_SESSION['user']['avatar'] = $fileName;
        }
    }
}

if ($userMapper->updateProfile($userEmail, $name, $surname, $userEmail)) {
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['surname'] = $surname;
    header('Location: ../profile.php?msg=updated');
} else {
    header('Location: ../profile.php?error=1&msg=error');
}
exit;
