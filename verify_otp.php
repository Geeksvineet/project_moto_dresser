<?php
session_start();
include("includes/db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the raw POST data and decode JSON
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'];
    $otp = $data['otp'];

    // Prepare a response array
    $response = [];

    // Fetch user data
    $query = "SELECT * FROM customer_login WHERE email = '$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $db_otp = $user['otp_code'];
        $otp_created_at = strtotime($user['otp_created_at']);

        // Check if OTP matches and is within 10 minutes
        if ($otp == $db_otp && (time() - $otp_created_at) < 600) {
            // OTP is valid, finalize registration
            $update_query = "UPDATE customer_login SET otp_code = NULL, otp_created_at = NULL WHERE email = '$email'";
            mysqli_query($con, $update_query);

            $response['success'] = true;
            $response['message'] = 'OTP verified successfully.';
        } else {
            // OTP is invalid or expired

            $update_query2 = "DELETE FROM customer_login WHERE email = '$email'";
            mysqli_query($con, $update_query2);


            $response['success'] = false;
            $response['message'] = 'Invalid or expired OTP. Please try again.';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'User not found.';
    }

    // Return JSON response
    echo json_encode($response);
    exit();
}
