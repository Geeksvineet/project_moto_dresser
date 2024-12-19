<?php
include './includes/db.php';

// function getPrice_vs($product_id)
// {
//     global $con;
//     $price_query = "SELECT * FROM product_prices WHERE product_id = $product_id";
//     $price_result = $con->query($price_query);
//     $price = $price_result->fetch_assoc();

//     return $price['price'];
// }

// function getPSPPrice_vs($product_id)
// {
//     global $con;
//     $price_query = "SELECT * FROM product_psp_prices WHERE product_id = $product_id";
//     $price_result = $con->query($price_query);
//     $price = $price_result->fetch_assoc();

//     return $price['psp_price'];
// }

function getImage_vs($product_id, $color = null)
{
    global $con;

    // Validate the product ID
    if (!$product_id) {
        return false; // Return false or handle this case as needed
    }

    // Construct the query based on whether a color is provided
    if ($color) {
        // If a color is provided, fetch images matching the color
        $query = "SELECT * FROM product_images WHERE product_id = ? AND color = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("is", $product_id, $color);
    } else {
        // If no color is provided, fetch all images for the product
        $query = "SELECT * FROM product_images WHERE product_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $product_id);
    }

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Return the result set for further processing
    return $result;
}
