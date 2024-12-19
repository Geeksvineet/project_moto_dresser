<?php
session_start();
require './includes/db.php';

// function getUserIp() {
//     return $_SERVER['REMOTE_ADDR'];
// }

$response = [];

if (isset($_POST['product_id']) && isset($_POST['action'])) {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];
    // $ip_add = getUserIp();
    $user_id = $_SESSION['user_id'];

    if ($action === 'increase') {
        $stmt = $con->prepare("UPDATE cart SET qty = qty + 1 WHERE p_id = ? AND customer_login_id = ?");
        $stmt->bind_param("ii", $product_id, $user_id);
    } elseif ($action === 'decrease') {
        $stmt = $con->prepare("UPDATE cart SET qty = qty - 1 WHERE p_id = ? AND customer_login_id = ?");
        $stmt->bind_param("ii", $product_id, $user_id);
    }

    $stmt->execute();

    // Calculate the updated subtotal, tax, and total
    $cart_query = "SELECT p_price, qty FROM cart WHERE p_id = '$product_id' AND customer_login_id = '$user_id'";
    $result = $con->query($cart_query);
    $row = $result->fetch_assoc();
    $subtotal = $row['p_price'] * $row['qty'];

    $cart_total_query = "SELECT SUM(p_price * qty) as total FROM cart WHERE customer_login_id = '$user_id'";
    $total_result = $con->query($cart_total_query);
    $total_row = $total_result->fetch_assoc();
    $total = $total_row['total'];
    
    $tax = $total * 0.18; // Example 18% tax
    $grand_total = $total + $tax;

    // Send the response back to AJAX
    $response['subtotal'] = number_format($subtotal, 2);
    $response['total'] = number_format($total, 2);
    $response['tax'] = number_format($tax, 2);
    $response['grand_total'] = number_format($grand_total, 2);

    echo json_encode($response);
}
?>
