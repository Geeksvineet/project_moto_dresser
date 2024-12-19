<?php
session_start();
include './includes/db.php';

header('Content-Type: application/json'); // Set the response type as JSON

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $comment = trim($_POST['comment']);
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

    // Validation
    if (empty($name) || empty($email) || empty($comment) || $rating <= 0 || $product_id <= 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'All fields are required and rating must be greater than 0.'
        ]);
        exit;
    }

    // Prepare and bind
    $stmt = $con->prepare("INSERT INTO reviews (product_id, name, email, comment, rating) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $product_id, $name, $email, $comment, $rating);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Your review has been submitted successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error: Could not submit your review. Please try again later.'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
?>
