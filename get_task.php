<?php
include 'auth.php';
include 'tasks.php';

if (isset($_GET['id'])) {
    $task = getTask($_GET['id']);
    if ($task) {
        header('Content-Type: application/json');
        echo json_encode($task);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Task not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Task ID required']);
}
?>