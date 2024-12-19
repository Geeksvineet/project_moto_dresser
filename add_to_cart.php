<?php
session_start();
require './includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login-page"); // Replace 'Login-page' with the path to your login page
    exit();
}

if (isset($_POST['product_id']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_POST['color']) && isset($_POST['size'])) {
    $p_id = $_POST['product_id'];
    $p_price = $_POST['price'];
    $qty = $_POST['quantity'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $user_id = $_SESSION['user_id'];

    // Check if the product with the same color and size already exists in the cart for this user
    $stmt = $con->prepare("SELECT * FROM cart WHERE p_id = ? AND customer_login_id = ? AND color = ? AND size = ?");
    $stmt->bind_param("isss", $p_id, $user_id, $color, $size);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the item with the same color and size exists, update the quantity
        $update_stmt = $con->prepare("UPDATE cart SET qty = qty + ? WHERE p_id = ? AND customer_login_id = ? AND color = ? AND size = ?");
        $update_stmt->bind_param("iisss", $qty, $p_id, $user_id, $color, $size);
        $update_stmt->execute();
    } else {
        // If the item is new, insert it into the cart
        $insert_stmt = $con->prepare("INSERT INTO cart (p_id, qty, p_price, customer_login_id, color, size) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("iissss", $p_id, $qty, $p_price, $user_id, $color, $size);
        $insert_stmt->execute();
    }

    // Redirect to the cart page after adding the item
    header("Location: cart");
    exit();
} else {
    echo "Invalid request.";
}
