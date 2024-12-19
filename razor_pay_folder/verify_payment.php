<?php
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

// Use Razorpay credentials
// $key_id = 'rzp_test_y6WArGYxmPokoL';
// $key_secret = 'YOUR_KEY_SECRET';

$key_id = "rzp_test_DfhbmLCnKJDWxO";
$key_secret = "YFZxjAWfyFyJidZXbXLu2UN0";

$api = new Api($key_id, $key_secret);

$data = json_decode(file_get_contents('php://input'), true);

$razorpay_order_id = $data['razorpay_order_id'];
$razorpay_payment_id = $data['razorpay_payment_id'];
$razorpay_signature = $data['razorpay_signature'];

try {
    $generated_signature = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, $key_secret);
    
    if ($generated_signature === $razorpay_signature) {
        echo json_encode(['message' => 'Payment verified successfully!']);
    } else {
        echo json_encode(['message' => 'Payment verification failed!']);
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
