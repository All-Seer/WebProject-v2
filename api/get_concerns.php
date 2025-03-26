<?php
require_once '../config/db.php';

try {
    $stmt = $pdo->query("
        SELECT 
            id,
            first_name as firstName,
            last_name as lastName,
            student_id as studentId,
            personal_email as email,
            concern,
            submission_date as date,
            IFNULL(status, 'Pending') as status
        FROM student_concerns
        ORDER BY submission_date DESC
    ");
    
    $concerns = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
