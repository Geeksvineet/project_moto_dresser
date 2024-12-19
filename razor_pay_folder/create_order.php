<?php
require('razorpay-php/Razorpay.php'); // Include the Razorpay PHP SDK

use Razorpay\Api\Api;

// Replace with your Razorpay credentials

$key_id = "rzp_test_DfhbmLCnKJDWxO";
$key_secret = "YFZxjAWfyFyJidZXbXLu2UN0";

// $key_id = 'rzp_test_y6WArGYxmPokoL';
// $key_secret = 'YOUR_KEY_SECRET';

// Initialize Razorpay API instance
$api = new Api($key_id, $key_secret);

// Order creation parameters
$orderData = [
    'receipt'         => 'order_rcptid_11',
    'amount'          => 50000, // Amount in paise (50000 paise = INR 500)
    'currency'        => 'INR',
    'payment_capture' => 1 // Auto-capture payment
];

try {
    $order = $api->order->create($orderData);
    echo json_encode(['order_id' => $order['id']]);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
