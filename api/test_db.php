<?php
require_once '../config/db.php';

try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM student_concerns");
    echo json_encode(['success' => true, 'message' => 'Database connected', 'concerns' => $stmt->fetchColumn()]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error', 'error' => $e->getMessage()]);
}
?>
<?php
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'request_uri' => $_SERVER['REQUEST_URI'],
    'document_root' => $_SERVER['DOCUMENT_ROOT'],
    'script_filename' => $_SERVER['SCRIPT_FILENAME']
]);
?>