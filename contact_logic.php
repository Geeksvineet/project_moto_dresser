<?php
session_start();
include './includes/db.php'; // Adjust the path to your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = [];

// Check if the user is logged in
$customer_login_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Check if the request is an AJAX POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Validate the required fields
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        $response['success'] = false;
        $response['message'] = 'Please fill in all the required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['success'] = false;
        $response['message'] = 'Invalid email address.';
    } else {
        // Prepare the SQL query based on login status
        if ($customer_login_id) {
            $query = "INSERT INTO contact (name, email, phone, message, customer_login_id, date_created) 
                      VALUES ('$name', '$email', '$phone', '$message', '$customer_login_id', NOW())";
        } else {
            $query = "INSERT INTO contact (name, email, phone, message, date_created) 
                      VALUES ('$name', '$email', '$phone', '$message', NOW())";
        }

        // Execute the query
        $result = mysqli_query($con, $query);

        // Check the result and respond accordingly
        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Message sent successfully!';
        } else {
            $response['success'] = false;
            $response['message'] = 'Failed to send message. Please try again.';
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request.';
}

// Return the response as JSON
echo json_encode($response);
