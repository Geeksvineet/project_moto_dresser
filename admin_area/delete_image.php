<?php
// delete_image.php

// Include database connection
require_once './includes/db.php';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

$imageId = $data['image_id'];

// Fetch the image filename from the database
$imageQuery = "SELECT image FROM product_images WHERE id = ?";
$stmt = $con->prepare($imageQuery);
$stmt->bind_param("i", $imageId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the image exists in the database
if ($result->num_rows > 0) {
    $image = $result->fetch_assoc();
    $imagePath = 'product_images/' . $image['image']; // Path to the image file on the server

    // Delete the image file from the server
    if (file_exists($imagePath)) {
        unlink($imagePath); // Delete the image file
    }

    // Now delete the image record from the database
    $deleteImageQuery = "DELETE FROM product_images WHERE id = ?";
    $stmt = $con->prepare($deleteImageQuery);
    $stmt->bind_param("i", $imageId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting image from the database']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Image not found']);
}

$stmt->close();
$con->close();
?>
