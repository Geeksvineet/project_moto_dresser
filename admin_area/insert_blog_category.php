<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login','_self')</script>";
} else {
?>
<div class="row"><!-- 1 row Starts -->
    <div class="col-lg-12"><!-- col-lg-12 Starts -->
        <ol class="breadcrumb"><!-- breadcrumb Starts -->
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Insert Blog Category
            </li>
        </ol><!-- breadcrumb Ends -->
    </div><!-- col-lg-12 Ends -->
</div><!-- 1 row Ends -->

<div class="row"><!-- 2 row Starts -->
    <div class="col-lg-12"><!-- col-lg-12 Starts -->
        <div class="panel panel-default"><!-- panel panel-default Starts -->
            <div class="panel-heading"><!-- panel-heading Starts -->
                <h3 class="panel-title"><!-- panel-title Starts -->
                    <i class="fa fa-folder fa-fw"> </i> Insert Blog Category
                </h3><!-- panel-title Ends -->
            </div><!-- panel-heading Ends -->
            <div class="panel-body"><!-- panel-body Starts -->
                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->
                    <div class="form-group"><!-- form-group Starts -->
                        <label class="col-md-3 control-label"> Category Name </label>
                        <div class="col-md-6">
                            <input type="text" name="category_name" class="form-control" required>
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group"><!-- form-group Starts -->
                        <label class="col-md-3 control-label"> Description </label>
                        <div class="col-md-6">
                            <textarea name="category_description" class="form-control" rows="5"></textarea>
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group"><!-- form-group Starts -->
                        <label class="col-md-3 control-label"> </label>
                        <div class="col-md-6">
                            <input type="submit" name="submit" class="form-control btn btn-primary" value=" Insert Blog Category ">
                        </div>
                    </div><!-- form-group Ends -->
                </form><!-- form-horizontal Ends -->
            </div><!-- panel-body Ends -->
        </div><!-- panel panel-default Ends -->
    </div><!-- col-lg-12 Ends -->
</div><!-- 2 row Ends -->

<?php
if(isset($_POST['submit'])){
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];

    // SQL to insert into blog_category
    $insert_category = "INSERT INTO blog_category (category, description, date_created) VALUES ('$category_name', '$category_description', NOW())";
    $run_category = mysqli_query($con, $insert_category);

    if($run_category){
        echo "<script>alert('New Blog Category Has Been Inserted')</script>";
        echo "<script>window.open('index?view_blog_category','_self')</script>";
    } else {
        echo "<script>alert('Error inserting category')</script>";
    }
}
?>
<?php } ?>
