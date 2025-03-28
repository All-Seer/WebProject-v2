<?php
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validate credentials
    if ($username === 'CSDL_ADMIN' && $password === 'CSDL_ADMIN') {
        $_SESSION['isAuthenticated'] = true;
        header('Location: navigationItems/dashboard.php');
        exit();
    }
}

// If credentials are invalid or not POST request
header('Location: login.php?error=1');
exit();
?>