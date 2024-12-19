<?php
session_start();
include './includes/db.php'; // Adjust the path if necessary

// Check if the admin is logged in
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login','_self')</script>";
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Landing Image</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Insert Landing Image</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Select Image:</label>
                <input type="file" class="form-control" name="image" required>
            </div>
            <div class="form-group">
                <label for="title">Image Title:</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="show">Display Image:</label>
                <select name="show" class="form-control" required>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Insert Image</button>
        </form>
    </div>

    <?php
    // Handle form submission
    if (isset($_POST['submit'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $show = mysqli_real_escape_string($con, $_POST['show']);

        // Handle the uploaded image
        $image = $_FILES['image']['name'];
        $temp_image = $_FILES['image']['tmp_name'];
        $image_path = "landing_images/" . basename($image);

        if (move_uploaded_file($temp_image, $image_path)) {
            $query = "INSERT INTO landing_images (image, title, `show`, date_created) VALUES ('$image', '$title', '$show', NOW())";
            $result = mysqli_query($con, $query);

            if ($result) {
                echo "<script>alert('Landing image inserted successfully!');</script>";
                echo "<script>window.open('index?view_landing_images','_self');</script>";
            } else {
                echo "<script>alert('Failed to insert image. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Failed to upload image. Please try again.');</script>";
        }
    }
    ?>
</body>
</html>

<?php } ?>
