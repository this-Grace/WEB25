<?php
require_once __DIR__ . '/../../app/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user']['id'])) {
    header('Location: /login.php');
    exit;
}

$userId = $_SESSION['user']['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = isset($_POST['save_draft']) ? 'DRAFT' : 'WAITING';
    $hour   = $_POST['event_time_hour'] ?? '00';
    $minute = $_POST['event_time_minute'] ?? '00';
    $fileNameToSave = 'photo1.jpeg';

    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../' . EVENTS_IMG_DIR;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(10)) . '.' . $ext;

        if (move_uploaded_file($_FILES['event_image']['tmp_name'], $uploadDir . $newFileName)) {
            $fileNameToSave = $newFileName;
            @chmod($uploadDir . $newFileName, 0644);
        }
    }

    $data = [
        'title'       => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'event_date'  => $_POST['event_date'] ?? '',
        'event_time'  => "$hour:$minute:00",
        'location'    => $_POST['location'] ?? '',
        'category_id' => (int)($_POST['category_id'] ?? 0),
        'total_seats' => (int)($_POST['max_seats'] ?? 0),
        'status'      => $status,
        'user_id'     => $userId,
        'image'       => $fileNameToSave
    ];

    if ($eventMapper->create($data)) {
        header('Location: ../profile.php');
    } else {
        header('Location: ../event.php?error=sql_error');
    }
    exit;
}

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit;
