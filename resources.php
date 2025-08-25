<?php
include 'auth.php';
include 'db.php';

// Get all resources
function getResources() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM resources");
    return $stmt->fetchAll();
}

// Update resource
function updateResource($id, $current) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE resources SET current = ? WHERE id = ?");
    return $stmt->execute([$current, $id]);
}

// Get progress data
function getProgress() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM progress ORDER BY id DESC LIMIT 1");
    return $stmt->fetch();
}

// Update progress
function updateProgress($overall, $terrain, $track, $stations) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE progress SET overall = ?, terrain_cleared = ?, track_laid = ?, stations_built = ? ORDER BY id DESC LIMIT 1");
    return $stmt->execute([$overall, $terrain, $track, $stations]);
}

// Handle resource updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_resources'])) {
        foreach ($_POST['resources'] as $id => $current) {
            updateResource($id, $current);
        }
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['update_progress'])) {
        updateProgress($_POST['overall'], $_POST['terrain'], $_POST['track'], $_POST['stations']);
        header("Location: index.php");
        exit();
    }
}
?>