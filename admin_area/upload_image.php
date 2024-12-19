<?php
require_once './includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $color = $_POST['color'];
    $productId = $_POST['product_id'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
            // Insert image record into the database
            $insertImageQuery = "INSERT INTO product_images (product_id, image, color) VALUES (?, ?, ?)";
            $stmt = $con->prepare($insertImageQuery);
            $stmt->bind_param("iss", $productId, $fileName, $color);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save image in database.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image file.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No image uploaded or upload error.']);
    }
}
?>
