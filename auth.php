<?php
session_start();
include 'db.php';

// Register function
function registerUser($username, $email, $password) {
    global $pdo;
    
    // Check if user already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    
    if ($stmt->rowCount() > 0) {
        return "Username or email already exists";
    }
    
    // Hash password and insert user
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    
    if ($stmt->execute([$username, $email, $hashedPassword])) {
        return true;
    } else {
        return "Registration failed";
    }
}

// Login function
function loginUser($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    } else {
        return "Invalid username or password";
    }
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Logout function
function logout() {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $result = registerUser($_POST['username'], $_POST['email'], $_POST['password']);
        if ($result === true) {
            $success = "Registration successful. Please login.";
        } else {
            $error = $result;
        }
    } elseif (isset($_POST['login'])) {
        $result = loginUser($_POST['username'], $_POST['password']);
        if ($result === true) {
            header("Location: index.php");
            exit();
        } else {
            $error = $result;
        }
    }
}

if (isset($_GET['logout'])) {
    logout();
}
?>