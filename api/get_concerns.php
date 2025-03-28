<?php
require_once '../config/db.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

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
    
    $data = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error',
        'error' => $e->getMessage()
    ]);
}