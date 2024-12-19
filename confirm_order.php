<?php
// confirm_order.php

require 'includes/db.php';
session_start();
$customer_login_id = $_SESSION['user_id'];

// Get payment details from the request
$paymentDetails = json_decode(file_get_contents('php://input'), true);

// Ensure necessary details are present
if (!$paymentDetails || !isset($paymentDetails['razorpay_payment_id']) || !isset($paymentDetails['orderDetails'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid payment details.']);
    exit();
}

$razorpayPaymentId = $paymentDetails['razorpay_payment_id'];
$orderDetails = $paymentDetails['orderDetails'];
$invoiceNo = $orderDetails['invoice_no'];
$totalAmount = $orderDetails['total_amount'];
$productsOrdered = $orderDetails['products_ordered'];
$paymentMethod = 'online';

// Save order to the database
$orderQuery = "INSERT INTO orders (customer_login_id, total_amount, invoice_no, payment_method, payment_status, payment_id, products_ordered)
               VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $con->prepare($orderQuery);
$paymentStatus = 'Completed'; // Set as 'Completed' if the payment was successful

$stmt->bind_param('idsssss', $customer_login_id, $totalAmount, $invoiceNo, $paymentMethod, $paymentStatus, $razorpayPaymentId, $productsOrdered);

if ($stmt->execute()) {
    // Successfully saved the order
    echo json_encode(['success' => true, 'message' => 'Order placed successfully.', 'invoice_no' => $invoiceNo]);
} else {
    // Failed to save the order
    echo json_encode(['success' => false, 'message' => 'Error saving order details: ' . $stmt->error]);
}

$stmt->close();
$con->close();
