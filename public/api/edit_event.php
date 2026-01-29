<?php
require_once __DIR__ . '/../../app/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
if ($eventId <= 0) {
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = (int)($_POST['event_id'] ?? 0);

    $currentEvent = $eventMapper->getEventById($eventId);

    if (!$currentEvent) {
        header('Location: ../profile.php?error=not_found');
        exit;
    }

    $hour   = $_POST['event_time_hour'] ?? '00';
    $minute = $_POST['event_time_minute'] ?? '00';
    $eventTime = "$hour:$minute:00";

    $imageToDatabase = $currentEvent['image'] ?? 'photo1.jpeg';

    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../' . EVENTS_IMG_DIR;

        $ext = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(10)) . '.' . $ext;

        if (move_uploaded_file($_FILES['event_image']['tmp_name'], $uploadDir . $newFileName)) {
            $oldImage = $currentEvent['image'] ?? '';
            if (!empty($oldImage) && $oldImage !== 'photo1.jpeg' && is_file($uploadDir . $oldImage)) {
                @unlink($uploadDir . $oldImage);
            }
            $imageToDatabase = $newFileName;
            @chmod($uploadDir . $newFileName, 0644);
        }
    }

    $updateData = [
        'title'       => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'event_date'  => $_POST['event_date'] ?? '',
        'event_time'  => "$hour:$minute:00",
        'location'    => $_POST['location'] ?? '',
        'category_id' => (int)($_POST['category_id'] ?? 0),
        'total_seats' => (int)($_POST['max_seats'] ?? 0),
        'image'       => $imageToDatabase
    ];

    if (isset($_POST['publish_from_draft'])) {
        $updateData['status'] = 'WAITING';
    }

    if ($eventMapper->updateEvent($updateData, $eventId)) {
        header('Location: ../profile.php');
    } else {
        header('Location: ../event.php?event_id=' . $eventId . '&error=1');
    }
    exit;
}

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit;
