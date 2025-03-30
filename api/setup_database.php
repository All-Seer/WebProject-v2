<?php

$host = "localhost";
$user = "root";
$pass = "";       

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS users");
    $pdo->exec("USE users");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS student_concerns (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(50) NOT NULL,
            middle_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            student_id VARCHAR(20) NOT NULL,
            personal_email VARCHAR(100) NOT NULL,
            concern TEXT NOT NULL,
            submission_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            status ENUM('Pending', 'Resolved') DEFAULT 'Pending',
            INDEX (status),
            INDEX (submission_date)
        )
    ");
    
    echo "Database and table created successfully!";
    
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}