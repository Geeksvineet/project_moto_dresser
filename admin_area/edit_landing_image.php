<?php

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login', '_self')</script>";
} else {
?>

<?php

if (isset($_GET['edit_landing_image'])) {
    $edit_id = $_GET['edit_landing_image'];

    $get_image = "SELECT * FROM landing_images WHERE id='$edit_id'";
    $run_edit = mysqli_query($con, $get_image);
    $row_edit = mysqli_fetch_array($run_edit);

    $image_id = $row_edit['id'];
    $current_image = $row_edit['image']; // Assuming the column name is `image_path`
    $image_caption = $row_edit['title']; // Example of another field you might have
    $show = $row_edit['show']; // Retrieve the `show` status from the database
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Landing Image</title>
</head>
<body>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Edit Landing Image
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-image"></i> Edit Landing Image
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-md-3 control-label">title</label>
                        <div class="col-md-6">
                            <input type="text" name="image_caption" class="form-control" required value="<?php echo $image_caption; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Image</label>
                        <div class="col-md-6">
                            <input type="file" name="image_file" class="form-control">
                            <br>
                            <img src="landing_images/<?php echo $current_image; ?>" width="100" height="100">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Show</label>
                        <div class="col-md-6">
                            <select name="show" class="form-control">
                                <option value="yes" <?php if($show == 'yes') echo 'selected'; ?>>Yes</option>
                                <option value="no" <?php if($show == 'no') echo 'selected'; ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                            <input type="submit" name="update_image" value="Update Image" class="btn btn-primary form-control">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php

if (isset($_POST['update_image'])) {
    $image_caption = $_POST['image_caption'];
    $show = $_POST['show']; // Get the value of the 'show' field from the form
    $image_file = $_FILES['image_file']['name'];
    $temp_name = $_FILES['image_file']['tmp_name'];

    // If a new image is uploaded
    if (!empty($image_file)) {
        // Delete the old image
        if (file_exists("landing_images/$current_image")) {
            unlink("landing_images/$current_image");
        }

        // Upload the new image
        move_uploaded_file($temp_name, "landing_images/$image_file");

        // Update the database with the new image path
        $update_image = "UPDATE landing_images SET title='$image_caption', image='$image_file', `show`='$show' WHERE id='$image_id'";
    } else {
        // If no new image is uploaded, update only the caption and 'show' status
        $update_image = "UPDATE landing_images SET title='$image_caption', `show`='$show' WHERE id='$image_id'";
    }

    $run_update = mysqli_query($con, $update_image);

    if ($run_update) {
        echo "<script>alert('Landing Image has been updated successfully')</script>";
        echo "<script>window.open('index.php?view_landing_images', '_self')</script>";
    }
}

?>

<?php } ?>
