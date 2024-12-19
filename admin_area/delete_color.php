<?php
require_once './includes/db.php'; // Ensure this file connects to the database

// Only accept POST requests with JSON data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
    $data = json_decode(file_get_contents("php://input"), true);
    $colorId = $data['id'];
    $colorName = $data['color'];
    $productId = $data['productId']; // Assuming `product_id` is passed in the JSON

    // Retrieve and delete associated images
    $getImagesQuery = "SELECT image FROM product_images WHERE color = ? AND product_id = ?";
    $stmtGetImages = $con->prepare($getImagesQuery);
    $stmtGetImages->bind_param("si", $colorName, $productId);
    $stmtGetImages->execute();
    $resultImages = $stmtGetImages->get_result();

    // Unlink images from the server
    while ($row = $resultImages->fetch_assoc()) {
        $imagePath = 'product_images/' . $row['image']; // Assuming 'uploads/' is the folder for images
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete image file
        }
    }
    $stmtGetImages->close();

    // Delete records from `product_images` table
    $deleteImagesQuery = "DELETE FROM product_images WHERE color = ? AND product_id = ?";
    $stmtDeleteImages = $con->prepare($deleteImagesQuery);
    $stmtDeleteImages->bind_param("si", $colorName, $productId);
    $stmtDeleteImages->execute();

    // Delete the color itself from `product_colors`
    $deleteColorQuery = "DELETE FROM product_colors WHERE id = ? AND product_id = ?";
    $stmtDeleteColor = $con->prepare($deleteColorQuery);
    $stmtDeleteColor->bind_param("ii", $colorId, $productId);
    $stmtDeleteColor->execute();

    // Check if deletion was successful
    if ($stmtDeleteColor->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Deletion failed']);
    }

    // Close statements
    $stmtDeleteImages->close();
    $stmtDeleteColor->close();
}
?>
