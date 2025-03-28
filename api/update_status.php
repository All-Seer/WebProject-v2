<?php
require_once '../config/db.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

try {
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Method not allowed", 405);
    }

    // Get and validate input
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON input", 400);
    }

    if (empty($input['id']) || !isset($input['status'])) {
        throw new Exception("Missing required parameters", 400);
    }

    // Update status in database
    $stmt = $pdo->prepare("UPDATE student_concerns SET status = :status WHERE id = :id");
    $stmt->execute([
        ':id' => $input['id'],
        ':status' => $input['status']
    ]);

    // Get updated record to return
    $stmt = $pdo->prepare("SELECT * FROM student_concerns WHERE id = :id");
    $stmt->execute([':id' => $input['id']]);
    $updatedRecord = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return success response
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Status updated successfully',
        'data' => $updatedRecord
    ]);
    
} catch (Exception $e) {
    // Return error response
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
exit();