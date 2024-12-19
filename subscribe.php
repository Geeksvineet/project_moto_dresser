<?php
session_start();
include './includes/db.php'; // Adjust the path to your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = [];

// Check if user is logged in and get their user ID if available
$customer_login_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Check if the request is an AJAX POST and the email field is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = [
            'success' => false,
            'message' => 'Invalid email address.'
        ];
        echo json_encode($response);
        exit();
    }

    // Check if the email is already subscribed
    $check_email_query = "SELECT * FROM subscription WHERE email = '$email'";
    $run_check = mysqli_query($con, $check_email_query);

    if (!$run_check) {
        $response = [
            'success' => false,
            'message' => 'Database query error. Please try again later.'
        ];
        echo json_encode($response);
        exit();
    }

    if (mysqli_num_rows($run_check) > 0) {
        $response = [
            'success' => false,
            'message' => 'This email is already subscribed.'
        ];
    } else {
        // Prepare the query to insert the email into the subscription table
        $query = "INSERT INTO subscription (email, customer_login_id, date_created) VALUES ('$email', " . ($customer_login_id ? "'$customer_login_id'" : 'NULL') . ", NOW())";
        $result = mysqli_query($con, $query);

        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Subscription successful!'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Subscription failed. Please try again.'
            ];
        }
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid request.'
    ];
}

// Return the response as JSON
echo json_encode($response);
?>
