<?php

require './includes/db.php';

// Fetch POST data (assuming it was sent as JSON)
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['productId']) && isset($data['quantity'])) {
    $productId = intval($data['productId']);
    $quantity = intval($data['quantity']);

    // Update quantity in the database (update the table name if necessary)
    $sql = "UPDATE cart SET qty = ? WHERE p_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $quantity, $productId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data.']);
}
?>
