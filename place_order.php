<?php
session_start();
require 'includes/db.php';

header('Content-Type: application/json'); // Set response type to JSON

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['customer_id'], $data['total_amount'], $data['invoice_no'], $data['qty'], $data['payment_method'], $data['products_ordered'])) {
    $customerId = $data['customer_id'];
    $totalAmount = $data['total_amount'];
    $invoiceNo = $data['invoice_no'];
    $qty = $data['qty'];
    $paymentMethod = $data['payment_method'];
    $productsOrdered = $data['products_ordered'];

    // Insert the order into my_orders table
    $orderQuery = "INSERT INTO my_orders (customer_id, total_amount, invoice_no, qty, payment_method, products_ordered) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($orderQuery);
    $stmt->bind_param("idssss", $customerId, $totalAmount, $invoiceNo, $qty, $paymentMethod, $productsOrdered);

    if ($stmt->execute()) {
        // Order placed successfully, now delete the cart items for the user
        $deleteCartQuery = "DELETE FROM cart WHERE customer_login_id = ?";
        $deleteStmt = $con->prepare($deleteCartQuery);
        $deleteStmt->bind_param("i", $customerId);

        if ($deleteStmt->execute()) {
            // Cart items deleted successfully
            $response = [
                'success' => true,
                'invoice_no' => $invoiceNo,
            ];
        } else {
            // Order placed but failed to delete cart items
            $response = [
                'success' => true,
                'invoice_no' => $invoiceNo,
                'message' => 'Order placed but failed to clear cart items: ' . $deleteStmt->error
            ];
        }

        $deleteStmt->close();
    } else {
        // Failed to place order
        $response = [
            'success' => false,
            'message' => 'Failed to place order: ' . $stmt->error
        ];
    }

    $stmt->close();
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid input data'
    ];
}

echo json_encode($response);
?>
