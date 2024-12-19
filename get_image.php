<?php
include('includes/db.php'); // Include your database connection

if (isset($_POST['color']) && isset($_POST['product_id'])) {
    $color = $_POST['color'];
    $product_id = $_POST['product_id'];

    if ($color == 'vinu_col') {
        $query = "SELECT * FROM product_images WHERE product_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $query = "SELECT * FROM product_images WHERE product_id = ? AND color = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("is", $product_id, $color);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    // Fetch images for the selected color

    // Output images as HTML
    while ($post = $result->fetch_assoc()) {
        echo '<div class="gallery_image">';
        echo '<img src="./admin_area/product_images/' . htmlspecialchars($post['image']) . '" alt="Product Image" />';
        echo '</div>';
    }

    $stmt->close();
}
