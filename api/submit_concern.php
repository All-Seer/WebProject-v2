<?php
// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../config/db.php';

try {
    // Get raw JSON input
    $json = file_get_contents('php://input');
    error_log("Raw input: " . $json); // Log raw input for debugging
    
    $data = json_decode($json, true);
    
    if (!$data) {
        throw new Exception("Invalid JSON input: " . json_last_error_msg());
    }

    $requiredFields = [
        'firstName' => 'First name',
        'lastName' => 'Last name',
        'studentID' => 'Student ID',
        'personalEmail' => 'Personal email',
        'phinmaedEmail' => 'PHINMA Ed email',
        'concern' => 'Concern'
    ];

    $optionalFields = [
        'middleName' => 'Middle name'
    ];

    // Log decoded data for debugging
    error_log("Decoded data: " . print_r($data, true));

    // Required fields (middleName is optional)
    $required = [
        'firstName', 
        'lastName',
        'studentID', 
        'personalEmail',
        'phinmaedEmail',
        'concern'
    ];

    // Validate required fields
    foreach ($required as $field) {
        if (!isset($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
        if (empty(trim($data[$field]))) {
            throw new Exception("Field cannot be empty: $field");
        }
    }

    // Prepare SQL with all fields including middle_name
    $stmt = $pdo->prepare("
        INSERT INTO student_concerns 
        (first_name, middle_name, last_name, student_id, personal_email, phinmaed_email, concern, status, submission_date) 
        VALUES (:firstName, :middleName, :lastName, :studentID, :personalEmail, :phinmaedEmail, :concern, 'Pending', NOW())

    ");

    // Execute with all parameters
    $stmt->execute([
        ':firstName' => htmlspecialchars(trim($data['firstName'])),
        ':middleName' => isset($data['middleName']) ? htmlspecialchars(trim($data['middleName'])) : null,
        ':lastName' => htmlspecialchars(trim($data['lastName'])),
        ':studentID' => htmlspecialchars(trim($data['studentID'])),
        ':personalEmail' => htmlspecialchars(trim($data['personalEmail'])),
        ':phinmaedEmail' => htmlspecialchars(trim($data['phinmaedEmail'])),
        ':concern' => htmlspecialchars(trim($data['concern']))
    ]);

    // Success response
    echo json_encode([
        'success' => true,
        'message' => 'Submission successful',
        'id' => $pdo->lastInsertId()
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    error_log("Database Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred',
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit;
}
?>