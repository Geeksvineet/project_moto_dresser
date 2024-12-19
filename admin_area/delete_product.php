<?php

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login','_self')</script>";
} else {

    if (isset($_GET['delete_product'])) {

        $delete_id = $_GET['delete_product'];

        // Step 1: Retrieve the image names from the product_images table
        $get_images = "SELECT image FROM product_images WHERE product_id='$delete_id'";
        $run_images = mysqli_query($con, $get_images);

        // Array to hold image names for deletion
        $images_to_delete = [];

        while ($row_images = mysqli_fetch_array($run_images)) {
            $images_to_delete[] = $row_images['image'];
        }

        // Step 2: Delete related data from associated tables
        $delete_suggestions = "DELETE FROM product_suggestions WHERE product_id='$delete_id'";
        mysqli_query($con, $delete_suggestions);

        $delete_sizes = "DELETE FROM product_sizes WHERE product_id='$delete_id'";
        mysqli_query($con, $delete_sizes);

        $delete_colors = "DELETE FROM product_colors WHERE product_id='$delete_id'";
        mysqli_query($con, $delete_colors);

        // Step 3: Delete all images from the product_images table
        $delete_images = "DELETE FROM product_images WHERE product_id='$delete_id'";
        mysqli_query($con, $delete_images);

        // Step 4: Delete product from the products table
        $delete_pro = "DELETE FROM products WHERE product_id='$delete_id'";
        $run_delete = mysqli_query($con, $delete_pro);

        // Step 5: Delete the images from the server
        foreach ($images_to_delete as $image) {
            if (file_exists("product_images/$image")) {
                unlink("product_images/$image");
            }
        }

        if ($run_delete) {
            echo "<script>alert('Product and all related data have been deleted.')</script>";
            echo "<script>window.open('index?view_products','_self')</script>";
        }
    }
}
?>
