<?php
require_once '../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $concernId = $_POST['concern_id'] ?? null;
    $newStatus = $_POST['new_status'] ?? null;

    // Validate inputs
    if (!$concernId || !in_array($newStatus, ['Pending', 'Done'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE student_concerns SET status = ? WHERE id = ?");
        $stmt->execute([$newStatus, $concernId]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
}