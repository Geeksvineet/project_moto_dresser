<?php
// validate_coupon.php
require 'includes/db.php'; // Database connection

$data = json_decode(file_get_contents('php://input'), true);
$couponCode = $data['code'];
$subtotal = $data['subtotal']; // Pass subtotal from the frontend

$response = ['success' => false];

if (!empty($couponCode)) {
    // Validate the coupon
    $couponQuery = "SELECT * FROM coupons WHERE coupon_code = ? AND coupon_limit > coupon_used";
    $stmt = $con->prepare($couponQuery);
    $stmt->bind_param("s", $couponCode);
    $stmt->execute();
    $couponResult = $stmt->get_result();

    if ($couponResult && $couponResult->num_rows > 0) {
        $coupon = $couponResult->fetch_assoc();
        $couponAmount = $coupon['coupon_price'];

        // Check if the coupon amount is a percentage
        if (strpos($couponAmount, '%') !== false) {
            // If percentage, calculate the discount based on subtotal
            $percentage = (float)str_replace('%', '', $couponAmount);
            $discount = ($subtotal * $percentage) / 100;
        } else {
            // Otherwise, use it as a fixed discount amount
            $discount = (float)$couponAmount;
        }

        // Check if the discount can be applied
        if ($discount > 0) {
            // Update the coupon_used count
            $updateCouponQuery = "UPDATE coupons SET coupon_used = coupon_used + 1 WHERE coupon_code = ?";
            $updateStmt = $con->prepare($updateCouponQuery);
            $updateStmt->bind_param("s", $couponCode);
            if ($updateStmt->execute()) {
                // Return the discount amount if successful
                $response['success'] = true;
                $response['amount'] = $discount;
            } else {
                $response['message'] = 'Failed to update coupon usage.';
            }
        } else {
            $response['message'] = 'Coupon code has no discount.';
        }
    } else {
        $response['message'] = 'Invalid or expired coupon code.';
    }
} else {
    $response['message'] = 'Coupon code is required.';
}

echo json_encode($response);
?>
