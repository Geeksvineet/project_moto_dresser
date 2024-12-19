<?php
include("includes/db.php"); // Include your database connection

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login','_self')</script>";
} else {
    if (isset($_GET['edit_blog'])) {
        $edit_id = $_GET['edit_blog'];

        // Fetch the blog post to edit
        $get_blog = "SELECT * FROM blog WHERE id='$edit_id'";
        $run_blog = mysqli_query($con, $get_blog);
        $row_blog = mysqli_fetch_array($run_blog);

        $blog_id = $row_blog['id'];
        $category = $row_blog['category'];
        $title = $row_blog['title'];
        $description = $row_blog['description'];
        $image = $row_blog['image'];
        $date_created = $row_blog['date_created'];
        // $cat_id2 = $row_blog['category'];
    }

    // Fetch categories for the dropdown
    $get_categories = "SELECT * FROM blog_category";
    $run_categories = mysqli_query($con, $get_categories);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Blog</title>
    <script src="https://cdn.tiny.cloud/1/ilxmnvavt27i9067549554do76ljitygk312q7ka1ipem14k/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#description',
            height: 500,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table directionality emoticons template paste'
            ],
            toolbar: 'undo redo | styleselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify |' +
                'bullist numlist outdent indent | link image media | code preview fullscreen | forecolor backcolor emoticons |' +
                'table insertdatetime charmap hr anchor',
            menubar: 'file edit view insert format tools table',
            image_advtab: true,
            branding: false,
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });
    </script>
</head>
<body>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"> </i> Dashboard / Edit Blog
                </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-pencil fa-fw"></i> Edit Blog
                    </h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Blog Title</label>
                            <div class="col-md-6">
                                <input type="text" name="title" class="form-control" required value="<?php echo $title; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Select Category</label>
                            <div class="col-md-6">
                                <select name="category" class="form-control">
                                    <!-- <option value="<?php echo $category; ?>"><?php echo $category; ?></option> -->
                                    <?php
                                    while ($row_category = mysqli_fetch_array($run_categories)) {
                                        $cat_id = $row_category['id'];
                                        $cat_title = $row_category['category'];
                                        echo "<option value='$cat_id'>$cat_title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Blog Image</label>
                            <div class="col-md-6">
                                <input type="file" name="image" class="form-control">
                                <br><img src="blog_images/<?php echo $image; ?>" width="70" height="70">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Blog Description</label>
                            <div class="col-md-6">
                                <textarea name="description" class="form-control" rows="15" id="description"><?php echo $description; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-6">
                                <input type="submit" name="update" value="Update Blog" class="btn btn-primary form-control">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['update'])) {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $description = $_POST['description'];

        $image = $_FILES['image']['name'];
        $temp_name = $_FILES['image']['tmp_name'];

        $old_img = $row_blog['image'];

        if (!empty($image)) {
            move_uploaded_file($temp_name, "blog_images/$image");
            unlink("blog_images/$old_img");
        } else {
            $image = $row_blog['image']; // Keep the old image if not updated
        }

        $update_blog = "UPDATE blog SET title='$title', category='$category', description='$description', image='$image', date_updated=NOW() WHERE id='$blog_id'";
        $run_update = mysqli_query($con, $update_blog);

        if ($run_update) {
            echo "<script>alert('Blog has been updated successfully');</script>";
            echo "<script>window.open('index?view_blogs','_self');</script>";
        }
    }
    ?>
</body>
</html>

<?php } ?>
