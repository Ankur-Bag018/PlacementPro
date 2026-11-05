<?php
session_start();
header('Content-Type: application/json');

// Check if user is authorized
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Coordinator' && $_SESSION['role'] !== 'Recruiter')) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['application_id']) && isset($_POST['new_status'])) {
    
    $conn = new mysqli('localhost', 'root', '', 'placementpro');
    
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit();
    }

    $app_id = $_POST['application_id'];
    $new_status = $_POST['new_status'];
    
    $update_sql = "UPDATE job_applications SET status = ? WHERE application_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $new_status, $app_id);
    
    if ($update_stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    }
    
    $update_stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request data']);
}
?>