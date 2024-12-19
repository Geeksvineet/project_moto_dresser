<?php
session_start();
require './includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$customer_login_id = $_SESSION['user_id']; // Logged-in customer ID

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Prepare the delete statement
    $stmt = $con->prepare("DELETE FROM cart WHERE p_id = ? AND customer_login_id = ?");
    $stmt->bind_param("ii", $product_id, $customer_login_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Product not found in the cart or already deleted']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete cart item: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Product ID not provided']);
}
?>
