<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type to JSON
header('Content-Type: application/json');

include('includes/db.php');

// Get the search query
$searchQuery = isset($_GET['q']) ? $_GET['q'] : '';

if ($searchQuery) {
    $searchQuery = "%$searchQuery%";
    $stmt = $con->prepare("
    SELECT products.*, MIN(product_images.image) AS image, product_images.color 
    FROM products 
    LEFT JOIN product_images ON products.product_id = product_images.product_id 
    WHERE products.product_title LIKE ?
    GROUP BY products.product_id
");
    $stmt->bind_param("s", $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();


    // Fetch the results and convert to JSON
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Return the JSON response
    echo json_encode($products);
} else {
    // Return an empty array if no search query is provided
    echo json_encode([]);
}

// Close connection
// $con->close();
