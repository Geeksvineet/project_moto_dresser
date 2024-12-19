<?php
include('./includes/db.php'); // Make sure to include your database connection

if(isset($_POST['p_cat_id'])) {
    $p_cat_id = $_POST['p_cat_id'];
    
    $get_cat = "SELECT * FROM categories WHERE p_cat_id = '$p_cat_id'";
    $run_cat = mysqli_query($con, $get_cat);
    
    if(mysqli_num_rows($run_cat) > 0) {
        // echo '<option value="">Select a Product Sub-Category</option>';
        while ($row_cat = mysqli_fetch_array($run_cat)) {
            $cat_id = $row_cat['cat_id'];
            $cat_title = $row_cat['cat_title'];
            echo "<option value='$cat_id'>$cat_title</option>";
        }
    } else {
        echo '<option value="">No Sub-Categories Available</option>'; // In case no subcategories found
    }
}
?>
