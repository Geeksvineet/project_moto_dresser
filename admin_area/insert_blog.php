<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login','_self')</script>";
} else {
?>

<!DOCTYPE html>
<html>

<head>
    <title>Insert Blog</title>
    <script src="https://cdn.tiny.cloud/1/ilxmnvavt27i9067549554do76ljitygk312q7ka1ipem14k/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#blog_desc',
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
    <div class="row"><!-- row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"> </i> Dashboard / Insert Blog
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- row Ends -->

    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title">
                        <i class="fa fa-pencil fa-fw"></i> Insert Blog
                    </h3>
                </div><!-- panel-heading Ends -->
                <div class="panel-body"><!-- panel-body Starts -->
                    <form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Blog Title </label>
                            <div class="col-md-6">
                                <input type="text" name="blog_title" class="form-control" required>
                            </div>
                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Blog Category </label>
                            <div class="col-md-6">
                                <select name="blog_category" class="form-control" required>
                                    <option value=""> Select a Blog Category </option>
                                    <?php
                                    // Fetch categories from blog_category table
                                    $get_categories = "SELECT * FROM blog_category";
                                    $run_categories = mysqli_query($con, $get_categories);
                                    while ($row_category = mysqli_fetch_array($run_categories)) {
                                        $category_id = $row_category['id'];
                                        $category_title = $row_category['category'];
                                        echo "<option value='$category_id'>$category_title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Blog Image </label>
                            <div class="col-md-6">
                                <input type="file" name="blog_image" class="form-control" required>
                            </div>
                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Blog Description </label>
                            <div class="col-md-6">
                                <textarea name="blog_desc" class="form-control" rows="15" id="blog_desc"></textarea>
                            </div>
                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-6">
                                <input type="submit" name="submit" value="Insert Blog" class="btn btn-primary form-control">
                            </div>
                        </div><!-- form-group Ends -->

                    </form><!-- form-horizontal Ends -->
                </div><!-- panel-body Ends -->
            </div><!-- panel panel-default Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 2 row Ends -->

</body>

</html>

<?php
if (isset($_POST['submit'])) {
    $blog_title = $_POST['blog_title'];
    $blog_category = $_POST['blog_category'];
    $blog_desc = mysqli_real_escape_string($con,$_POST['blog_desc']);
    $blog_image = $_FILES['blog_image']['name'];
    $temp_name = $_FILES['blog_image']['tmp_name'];

    // Move the uploaded image to the desired directory
    move_uploaded_file($temp_name, "blog_images/$blog_image");

    // Insert blog data into the database
    $insert_blog = "INSERT INTO blog (category, title, description, image) VALUES ('$blog_category', '$blog_title', '$blog_desc', '$blog_image')";

    $run_blog = mysqli_query($con, $insert_blog);

    if ($run_blog) {
        echo "<script>alert('Blog has been inserted successfully')</script>";
        echo "<script>window.open('index?view_blogs','_self')</script>";
    } else {
        echo "<script>alert('Failed to insert blog.')</script>";
    }
}
?>
<?php } ?>
