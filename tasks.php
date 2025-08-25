<?php
include 'auth.php';
include 'db.php';

// Get all tasks
function getTasks() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

// Get single task
function getTask($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// Add new task
function addTask($title, $description, $workers, $tools) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO tasks (title, description, workers, tools) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$title, $description, $workers, $tools]);
}

// Update task
function updateTask($id, $title, $description, $progress, $workers, $tools, $status) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, progress = ?, workers = ?, tools = ?, status = ? WHERE id = ?");
    return $stmt->execute([$title, $description, $progress, $workers, $tools, $status, $id]);
}

// Delete task
function deleteTask($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    return $stmt->execute([$id]);
}

// Handle task operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task'])) {
        if (addTask($_POST['title'], $_POST['description'], $_POST['workers'], $_POST['tools'])) {
            header("Location: index.php");
            exit();
        }
    } elseif (isset($_POST['update_task'])) {
        if (updateTask($_POST['id'], $_POST['title'], $_POST['description'], $_POST['progress'], $_POST['workers'], $_POST['tools'], $_POST['status'])) {
            header("Location: index.php");
            exit();
        }
    } elseif (isset($_GET['delete_task'])) {
        if (deleteTask($_GET['delete_task'])) {
            header("Location: index.php");
            exit();
        }
    }
}
?>