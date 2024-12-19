<?php
session_start();

$amount = $_POST['amount']; // Amount from the checkout form
$customer_name = $_SESSION['user_name'];
$invoice_no = uniqid('INV_'); // Generate a unique invoice number
$payee_upi_id = 'example@upi'; // Replace with your UPI ID
$payee_name = 'Moto Dresser'; // Replace with your store name
$transaction_note = 'Payment for order ' . $invoice_no;

// Construct the UPI payment URL
$upi_link = 'upi://pay?pa=' . urlencode($payee_upi_id) .
            '&pn=' . urlencode($payee_name) .
            '&tr=' . urlencode($invoice_no) .
            '&tn=' . urlencode($transaction_note) .
            '&am=' . urlencode($amount) .
            '&cu=INR';

// Output the link for the frontend
echo json_encode([
    'success' => true,
    'upi_link' => $upi_link
]);
?>
