<?php
require_once __DIR__ . '/../../app/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$eventId = isset($_REQUEST['event_id']) ? (int)$_REQUEST['event_id'] : 0;
$userId  = $_SESSION['user']['id'] ?? null;

if ($eventId <= 0 || !$userId) {
    if (isset($_GET['action'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Sessione scaduta o ID mancante']);
        exit;
    }
    header('Location: ../index.php');
    exit;
}

$currentEvent = $eventMapper->getEventById($eventId);

if (!$currentEvent || (int)$currentEvent['user_id'] !== $userId) {
    if (isset($_GET['action'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Non autorizzato']);
        exit;
    }
    header('Location: ../profile.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'publish_from_draft') {
    header('Content-Type: application/json; charset=utf-8');
    
    if ($eventMapper->update(['status' => 'WAITING'], $eventId)) {
        $event = $eventMapper->getEventById($eventId);
        
        ob_start();
        include __DIR__ . '/../partials/event-card.php';
        $html = ob_get_clean();

        echo json_encode(['success' => true, 'html' => $html]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore durante la pubblicazione']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $hour   = $_POST['event_time_hour'] ?? '00';
    $minute = $_POST['event_time_minute'] ?? '00';
    $eventTime = "$hour:$minute:00";

    $imageToDatabase = $currentEvent['image'] ?? 'photo1.jpeg';

    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../' . EVENTS_IMG_DIR;

        $ext = strtolower(pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION));
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
        'title'       => $_POST['title'] ?? $currentEvent['title'],
        'description' => $_POST['description'] ?? $currentEvent['description'],
        'event_date'  => $_POST['event_date'] ?? $currentEvent['event_date'],
        'event_time'  => $eventTime,
        'location'    => $_POST['location'] ?? $currentEvent['location'],
        'category_id' => (int)($_POST['category_id'] ?? $currentEvent['category_id']),
        'total_seats' => (int)($_POST['max_seats'] ?? $currentEvent['total_seats']),
        'image'       => $imageToDatabase
    ];

    if (isset($_POST['publish_from_draft'])) {
        $updateData['status'] = 'WAITING';
    }

    if ($eventMapper->update($updateData, $eventId)) {
        header('Location: ../profile.php');
    } else {
        header('Location: ../event.php?event_id=' . $eventId . '&error=sql_fail');
    }
    exit;
}

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit;
