<?php
session_start();
include './includes/db.php'; // Database connection

$data = json_decode(file_get_contents('php://input'), true);
$customer_login_id = $_SESSION['user_id'];
$address = $data['address'];
$city = $data['city'];
$country = $data['country'];
$pincode = $data['pincode'];

// Update the customer's address in the database
$query = "UPDATE customers SET customer_address = ?, customer_city = ?, customer_country = ?, customer_pincode = ? WHERE customer_login_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('sssii', $address, $city, $country, $pincode, $customer_login_id);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

echo json_encode($response);
?>
