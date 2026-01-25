<?php
require_once __DIR__ . '/../../app/bootstrap.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])) {
    header('Location: ../profile.php');
    exit;
}

$userEmail = $_SESSION['user']['email'];
$name = trim($_POST['name']);
$surname = trim($_POST['surname']);

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $fileName = time() . '_' . basename($_FILES['avatar']['name']);
    $uploadPath = __DIR__ . '/../' . PROFILE_IMG_DIR . $fileName;
    
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath)) {
        $userMapper->updateAvatar($userEmail, $fileName);
        $_SESSION['user']['avatar'] = $fileName;
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