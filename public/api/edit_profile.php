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
    // Basic hardening: validate size, image type, restrict extensions and use a safe filename
    $maxSize = 2 * 1024 * 1024; // 2 MB
    $tmpPath = $_FILES['avatar']['tmp_name'];
    if ($_FILES['avatar']['size'] <= $maxSize) {
        $imgInfo = @getimagesize($tmpPath);
        if ($imgInfo !== false) {
            $mime = $imgInfo['mime'] ?? '';
            $allowed = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif'
            ];
            if (isset($allowed[$mime])) {
                $ext = $allowed[$mime];
                // create a secure random filename
                try {
                    $fileName = bin2hex(random_bytes(16)) . '.' . $ext;
                } catch (Exception $e) {
                    $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', basename($_FILES['avatar']['name']));
                }

                $uploadDir = __DIR__ . '/../' . PROFILE_IMG_DIR;
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($tmpPath, $uploadPath)) {
                    // set safe permissions and update DB
                    @chmod($uploadPath, 0644);
                    // remove old avatar if any and not empty/default
                    $old = $_SESSION['user']['avatar'] ?? '';
                    if ($old) {
                        $oldPath = $uploadDir . $old;
                        if (is_file($oldPath) && strpos(realpath($oldPath), realpath($uploadDir)) === 0) {
                            @unlink($oldPath);
                        }
                    }

                    $userMapper->updateAvatar($userEmail, $fileName);
                    $_SESSION['user']['avatar'] = $fileName;
                }
            }
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
