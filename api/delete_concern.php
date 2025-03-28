<?php
require_once '../config/db.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$input = json_decode(file_get_contents('php://input'), true);

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Method not allowed", 405);
    }

    if (empty($input['id'])) {
        throw new Exception("Missing concern ID", 400);
    }

    $stmt = $pdo->prepare("DELETE FROM student_concerns WHERE id = :id");
    $stmt->execute([':id' => $input['id']]);

    echo json_encode([
        'success' => true,
        'message' => 'Concern deleted successfully'
    ]);

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}