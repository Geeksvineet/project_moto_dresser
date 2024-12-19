<?php
// Include database connection
include('includes/db.php');

// Check if the request method is POST and the order_id is provided
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);

    // Initialize variables for status updates
    $statusUpdated = false;

    // Update order status if set in the POST request
    if (isset($_POST['order_status'])) {
        $order_status = mysqli_real_escape_string($con, $_POST['order_status']);
        $update_order_status_query = "UPDATE my_orders SET order_status='$order_status' WHERE order_id='$order_id'";

        if (mysqli_query($con, $update_order_status_query)) {
            $statusUpdated = true;
        } else {
            echo "<script>alert('Error updating order status');</script>";
        }
    }

    // Update payment status if set in the POST request
    if (isset($_POST['payment_status'])) {
        $payment_status = mysqli_real_escape_string($con, $_POST['payment_status']);
        $update_payment_status_query = "UPDATE my_orders SET payment_status='$payment_status' WHERE order_id='$order_id'";

        if (mysqli_query($con, $update_payment_status_query)) {
            $statusUpdated = true;
        } else {
            echo "<script>alert('Error updating payment status');</script>";
        }
    }

    // Redirect back to the orders page with a success message if any status was updated
    if ($statusUpdated) {
        echo "<script>alert('Status updated successfully');</script>";
        echo "<script>window.open('index?view_orders', '_self');</script>";
    } else {
        echo "<script>alert('No changes were made');</script>";
        echo "<script>window.open('index?view_orders', '_self');</script>";
    }
} else {
    // If the request is invalid or order_id is not provided, redirect to orders page
    echo "<script>alert('Invalid request');</script>";
    echo "<script>window.open('index?view_orders', '_self');</script>";
}
?>
