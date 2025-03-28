<?php
require_once '../config/db.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $query = '%' . $data['query'] . '%';

    $stmt = $pdo->prepare("
        SELECT 
            id,
            CONCAT(first_name, ' ', IFNULL(middle_name, ''), ' ', last_name) as student_name,
            student_id,
            personal_email as email,
            concern,
            submission_date
        FROM student_concerns
        WHERE 
            first_name LIKE :query OR
            middle_name LIKE :query OR
            last_name LIKE :query OR
            student_id LIKE :query OR
            personal_email LIKE :query OR
            phinmaed_email LIKE :query OR
            concern LIKE :query
        ORDER BY submission_date DESC
        LIMIT 10
    ");

    $stmt->execute([':query' => $query]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}