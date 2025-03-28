<?php
// Set headers FIRST - before any output
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

// Disable HTML error display
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Absolute path require to prevent include path issues
require_once __DIR__ . '/../config/db.php';

try {
    // Verify request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException("Method not allowed", 405);
    }

    // Get and validate JSON input
    $json = file_get_contents('php://input');
    if (empty($json)) {
        throw new RuntimeException("Empty request body", 400);
    }
    
    $input = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException("Invalid JSON: " . json_last_error_msg(), 400);
    }

    // Validate required fields
    $required = ['firstName', 'lastName', 'studentId', 'personalEmail', 'phinmaedEmail', 'concern'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            throw new RuntimeException("Missing required field: $field", 400);
        }
    }

    // Prepare SQL statement
    $stmt = $pdo->prepare("
        INSERT INTO student_concerns (
            first_name, 
            middle_name,
            last_name, 
            student_id, 
            personal_email, 
            phinmaed_email, 
            concern,
            status,
            submission_date
        ) VALUES (
            :firstName, 
            :middleName,
            :lastName, 
            :studentId, 
            :personalEmail, 
            :phinmaedEmail, 
            :concern,
            'Pending',
            NOW()
        )
    ");

    // Execute with error handling
    $success = $stmt->execute([
        ':firstName' => $input['firstName'],
        ':middleName' => $input['middleName'] ?? null,
        ':lastName' => $input['lastName'],
        ':studentId' => $input['studentId'],
        ':personalEmail' => $input['personalEmail'],
        ':phinmaedEmail' => $input['phinmaedEmail'],
        ':concern' => $input['concern']
    ]);

    if (!$success) {
        throw new RuntimeException("Database insert failed", 500);
    }

    // Successful response
    echo json_encode([
        'success' => true,
        'message' => 'Concern submitted successfully',
        'id' => $pdo->lastInsertId()
    ]);

} catch (Throwable $e) {
    // Error response
    http_response_code($e->getCode() >= 400 ? $e->getCode() : 500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error' => $e->getCode()
    ]);
    exit(1);
}