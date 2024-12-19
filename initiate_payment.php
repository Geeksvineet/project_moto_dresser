<?php
// initiate_payment.php

require 'includes/db.php';
require 'razorpay-php/Razorpay.php'; // Ensure you have Razorpay SDK installed

use Razorpay\Api\Api;

// Razorpay API credentials
$keyId = 'your_razorpay_key_id';
$keySecret = 'your_razorpay_key_secret';

session_start();
$customer_login_id = $_SESSION['user_id'];

// Get order details from the request
$orderDetails = json_decode(file_get_contents('php://input'), true);

// Ensure necessary details are present
if (!$orderDetails || !isset($orderDetails['total_amount']) || !isset($orderDetails['invoice_no'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid order details.']);
    exit();
}

$totalAmount = $orderDetails['total_amount'];
$invoiceNo = $orderDetails['invoice_no'];

// Initialize Razorpay API
$api = new Api($keyId, $keySecret);

try {
    // Create a Razorpay order
    $order = $api->order->create([
        'receipt' => $invoiceNo,
        'amount' => $totalAmount * 100, // Amount in paise
        'currency' => 'INR',
        'payment_capture' => 1 // Auto-capture
    ]);

    $orderId = $order['id'];

    // Send order ID back to the frontend
    echo json_encode(['success' => true, 'order_id' => $orderId]);
} catch (Exception $e) {
    // Handle error
    echo json_encode(['success' => false, 'message' => 'Error creating Razorpay order: ' . $e->getMessage()]);
}
