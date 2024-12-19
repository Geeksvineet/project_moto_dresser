<?php
require 'includes/db.php';
$product_id = $_GET['product_id'];
$size = $_GET['size'];

$query = "
    SELECT pp.price, psp.psp_price 
    FROM product_prices AS pp 
    JOIN product_psp_prices AS psp ON pp.product_id = psp.product_id AND pp.size = psp.size 
    WHERE pp.product_id = $product_id AND pp.size = '$size' LIMIT 1";
$result = $con->query($query);
$response = ['success' => false];

if ($result && $row = $result->fetch_assoc()) {
    $response['success'] = true;
    $response['price'] = $row['price'];
    $response['psp_price'] = $row['psp_price'];
}

echo json_encode($response);
?>
