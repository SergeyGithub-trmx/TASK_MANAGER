<?php

require_once('init.php');

if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit;
}

$user_id = intval($_SESSION['user']['id']);
$task_id = intval($_GET['task'] ?? 0);

if ($task = $db->getTaskById($task_id, $user_id)) {
    $new_task_status = intval($task['is_completed']) ? 0 : 1;
    $db->updateTaskStatus($task_id, $new_task_status);

    $ref = $_SERVER['HTTP_REFERER'] ?? '\index.php';
    header("Location: $ref");
    exit;
}

http_response_code(404);
exit;
