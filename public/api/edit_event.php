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

$sessionEmail = $_SESSION['user']['email'] ?? '';
$event = $eventMapper->getEventById($eventId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // publish from draft without edits
    if (isset($_POST['publish_from_draft']) && !isset($_POST['title'])) {
        $success = $eventMapper->updateEvent(['status' => 'WAITING'], $eventId);
        header('Location: ../profile.php?msg=published');
        exit;
    }

    $hour   = $_POST['event_time_hour'] ?? '00';
    $minute = $_POST['event_time_minute'] ?? '00';

    $updateData = [
        'title'       => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'event_date'  => $_POST['event_date'] ?? '',
        'event_time'  => "$hour:$minute:00",
        'location'    => $_POST['location'] ?? '',
        'category_id' => (int)($_POST['category_id'] ?? 0),
        'total_seats' => (int)($_POST['max_seats'] ?? 0)
    ];

    if (isset($_POST['publish_from_draft'])) {
        $updateData['status'] = 'WAITING';
    }

    if (!empty($_FILES['event_image']['tmp_name'])) {
        $filename = basename($_FILES['event_image']['name']);
        $targetFile = EVENTS_IMG_DIR . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
        if (move_uploaded_file($_FILES['event_image']['tmp_name'], $targetFile)) {
            $updateData['image'] = $targetFile;
        }
    }

    $success = $eventMapper->updateEvent($updateData, $eventId);

    if ($success) {
        header('Location: ../profile.php');
    } else {
        header('Location: ../event.php?event_id=' . $eventId . '&error=1');
    }
    exit;
}

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit;
