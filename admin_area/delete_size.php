<?php
require_once './includes/db.php'; // Ensure this file connects to the database

// Only accept POST requests with JSON data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
    $data = json_decode(file_get_contents("php://input"), true);
    $sizeId = $data['id'];

    // Delete the size
    $query = "DELETE FROM product_sizes WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $sizeId);
    $stmt->execute();

    // Check if the delete was successful
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Deletion failed']);
    }
    $stmt->close();
}
?>
